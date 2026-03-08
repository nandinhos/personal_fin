<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use CihanSenturk\OfxParser\Ofx;
use Illuminate\Support\Facades\Auth;

class AccountImportForm extends Component
{
    use WithFileUploads;

    public $accountId;
    public $file;
    public $showModal = false;
    public $importCount = 0;
    public $skipCount = 0;

    #[On('import-modal-open')]
    public function openModal()
    {
        $this->reset(['file', 'importCount', 'skipCount']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public $parsedTransactions = [];
    public $isPreviewing = false;
    public $categories = [];

    public function mount()
    {
        // categories loaded dynamically based on user
    }

    public function previewImport()
    {
        $this->validate([
            'file' => 'required|file|max:2048', // Removed strict MIME types due to OFX inconsistencies across browsers
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $account = Account::findOrFail($this->accountId);
        $profileId = $user->currentProfile()->id;

        // Security check
        if ($account->profile_id !== $profileId) {
            abort(403);
        }

        // Load categories to enable semantic matching
        $this->categories = \App\Models\Category::where('profile_id', $profileId)
                                ->orderBy('name', 'asc')
                                ->get()
                                ->toArray();

        try {
            $ofxFileContent = \file_get_contents($this->file->getRealPath());

            $parser = new \CihanSenturk\OfxParser\Parser();
            $ofx = $parser->loadFromString($ofxFileContent);

            $bankAccount = reset($ofx->bankAccounts);
            if (!$bankAccount) {
                session()->flash('error', 'Nenhuma conta bancária encontrada no arquivo OFX.');
                return;
            }

            $transactions = $bankAccount->statement->transactions;
            
            $previewList = [];

            foreach ($transactions as $index => $transaction) {
                $amount = (float) $transaction->amount;
                $date = $transaction->date;
                $description = $transaction->memo ?: ($transaction->name ?: 'Movimento Importado');
                $type = $amount < 0 ? 'expense' : 'income';
                
                // Anti-duplication heuristic
                $exists = Transaction::where('account_id', $this->accountId)
                    ->where('amount', abs($amount))
                    ->where('date', $date->format('Y-m-d'))
                    ->where('description', 'like', "%{$description}%")
                    ->exists();

                // Semantic category guessing
                $guessedCategoryId = $this->guessCategory($description, $type);

                $previewList[] = [
                    'id' => uniqid('tx_'),    
                    'amount' => abs($amount),
                    'date' => $date->format('Y-m-d'),
                    'description' => substr($description, 0, 100),
                    'type' => $type,
                    'category_id' => $guessedCategoryId,
                    'is_duplicate' => $exists,
                    'import' => !$exists // Default select if not duplicate
                ];
            }

            $this->parsedTransactions = $previewList;
            $this->isPreviewing = true;
            session()->flash('success', 'Arquivo lido com sucesso. Verifique os lançamentos antes de salvar.');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao processar o arquivo (Formato inválido?): ' . $e->getMessage());
        }
    }

    private function guessCategory($description, $type)
    {
        $descLower = strtolower($description);
        
        // Basic keywords mapping for common semantic matches in BR
        $keywords = [
            'mercado' => ['supermercado', 'atacamento', 'assai', 'carrefour', 'extra', 'pao de acucar'],
            'transporte' => ['uber', '99', 'posto', 'gasolina', 'combustivel', 'ipiranga', 'shell'],
            'alimentação' => ['ifood', 'rappi', 'restaurante', 'lanchonete', 'padaria', 'mcdonalds', 'burger king'],
            'saúde' => ['farmacia', 'drogaria', 'hospital', 'clinica', 'unimed', 'amil'],
            'educação' => ['escola', 'faculdade', 'universidade', 'curso', 'udemy'],
            'lazer' => ['cinema', 'netflix', 'spotify', 'amazon', 'prime', 'ingresso'],
            'moradia' => ['energia', 'agua', 'luz', 'celg', 'copasa', 'sabesp', 'condominio', 'aluguel'],
            'salário' => ['salario', 'pagamento', 'adiantamento', 'vale'],
            'transferência' => ['pix', 'ted', 'doc', 'transferencia', 'transf'],
        ];

        // 1. Try to match predefined keywords to find a generic category name mapped
        $matchedKeywordGroup = null;
        foreach ($keywords as $group => $words) {
            foreach ($words as $word) {
                if (\str_contains($descLower, $word)) {
                    $matchedKeywordGroup = $group;
                    break 2;
                }
            }
        }

        // 2. Iterate through user categories
        foreach ($this->categories as $category) {
            // Must match the flow direction (income/expense)
            if ($category['type'] !== $type) continue;
            
            $catLabelLower = strtolower($category['name']);

            // Direct exact or partial match of category name in description
            if (\str_contains($descLower, $catLabelLower)) {
                return $category['id'];
            }

            // Indirect match via predefined keywords group
            if ($matchedKeywordGroup && \str_contains($catLabelLower, $matchedKeywordGroup)) {
                return $category['id'];
            }
        }

        return null;
    }

    public function cancelPreview()
    {
        $this->isPreviewing = false;
        $this->parsedTransactions = [];
        $this->file = null;
    }

    public function confirmImport()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $account = Account::findOrFail($this->accountId);

        if ($account->profile_id !== $user->currentProfile()->id) {
            abort(403);
        }

        $imported = 0;
        $skipped = 0;

        foreach ($this->parsedTransactions as $tx) {
            if ($tx['import']) {
                Transaction::create([
                    'profile_id' => $user->currentProfile()->id,
                    'account_id' => $this->accountId,
                    'category_id' => $tx['category_id'] ?: null,
                    'type' => $tx['type'],
                    'amount' => $tx['amount'],
                    'description' => $tx['description'],
                    'date' => $tx['date'],
                    'is_imported' => true // Distinguishes imported vs manual
                ]);
                $imported++;

                // Update account balance
                if ($tx['type'] === 'expense') {
                    $account->balance -= $tx['amount'];
                } else {
                    $account->balance += $tx['amount'];
                }
            } else {
                $skipped++;
            }
        }

        $account->save();
        
        $this->importCount = $imported;
        $this->skipCount = $skipped;
        $this->isPreviewing = false;
        $this->parsedTransactions = [];
        $this->file = null;
        
        session()->flash('success', "Importação concluída: {$imported} salvos, {$skipped} pulados.");
        
        $this->dispatch('account-saved'); // to refresh the main screen
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.account-import-form');
    }
}

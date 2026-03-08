<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use CihanSenturk\OfxParser\Ofx;

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

    public function processImport()
    {
        $this->validate([
            'file' => 'required|file|mimes:txt,csv,ofx,xml|max:10240', // OFX is often text or xml MIME
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $account = Account::findOrFail($this->accountId);

        // Security check
        if ($account->profile_id !== $user->currentProfile()->id) {
            abort(403);
        }

        try {
            // Using modern CihanSenturk\OfxParser
            $ofxFileContent = \file_get_contents($this->file->getRealPath());

            // Need to clean headers from OFX before passing to parser as it's expecting strict XML or clean OFX
            // The parser doesn't expose loadFromFile directly in standard way sometimes, let's load it
            $parser = new \CihanSenturk\OfxParser\Parser();
            
            $ofx = $parser->loadFromString($ofxFileContent);

            $bankAccount = reset($ofx->bankAccounts);
            if (!$bankAccount) {
                session()->flash('error', 'Nenhuma conta bancária encontrada no arquivo OFX.');
                return;
            }

            $transactions = $bankAccount->statement->transactions;
            
            $imported = 0;
            $skipped = 0;

            foreach ($transactions as $transaction) {
                $amount = $transaction->amount;
                $date = $transaction->date;
                $description = $transaction->memo ?: ($transaction->name ?: 'Movimento Importado');
                $type = $amount < 0 ? 'expense' : 'income';
                
                // Anti-duplication heuristic
                $exists = Transaction::where('account_id', $this->accountId)
                    ->where('amount', abs($amount))
                    ->where('date', $date->format('Y-m-d'))
                    ->where('description', 'like', "%{$description}%")
                    ->exists();

                if (!$exists) {
                    Transaction::create([
                        'profile_id' => $user->currentProfile()->id,
                        'account_id' => $this->accountId,
                        'category_id' => null, // Left empty to be categorized later
                        'type' => $type,
                        'amount' => abs($amount),
                        'description' => $description,
                        'date' => $date->format('Y-m-d')
                    ]);
                    $imported++;

                    // Update account balance
                    $account->balance += $amount; // if it's expense, amount is negative, so += is correct
                } else {
                    $skipped++;
                }
            }

            $account->save();
            
            $this->importCount = $imported;
            $this->skipCount = $skipped;
            
            session()->flash('success', "Importação concluída: {$imported} importados, {$skipped} ignorados (duplicados).");
            
            $this->dispatch('account-saved'); // to refresh the main screen

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao processar o arquivo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.account-import-form');
    }
}

<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Category;

class AccountShow extends Component
{
    use WithPagination;

    public Account $account;
    public $showForm = false;

    public function mount(Account $account)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Security check
        if ($account->profile_id !== $user->currentProfile()->id) {
            abort(403);
        }

        $this->account = $account;
    }

    public function openForm()
    {
        $this->showForm = true;
    }

    #[On('account-saved')]
    public function onAccountSaved()
    {
        $this->showForm = false;
        $this->account->refresh();
        session()->flash('success', 'Conta atualizada com sucesso.');
    }

    #[On('close-account-form')]
    public function cancelForm()
    {
        $this->showForm = false;
    }

    public function deleteAccount()
    {
        $this->account->delete();
        session()->flash('success', 'Conta excluída com sucesso.');
        return $this->redirectRoute('accounts.index', navigate: true);
    }

    public function openQuickTransaction()
    {
        $this->dispatch('quick-transaction-open');
    }

    public function importData()
    {
        $this->dispatch('import-modal-open');
    }

    public $selectedTransactions = [];
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTransactions = Transaction::where(function ($query) {
                    $query->where('account_id', $this->account->id)
                          ->orWhere('to_account_id', $this->account->id);
                })
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedTransactions = [];
        }
    }

    public function deleteSelectedTransactions()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (empty($this->selectedTransactions)) {
            return;
        }

        Transaction::whereIn('id', $this->selectedTransactions)->delete();

        $this->account->recalculateBalance();
        $this->selectedTransactions = [];
        $this->selectAll = false;

        session()->flash('success', 'Lançamentos selecionados foram excluídos com sucesso.');
    }

    public function deleteTransaction($id)
    {
        $tx = Transaction::findOrFail($id);
        $tx->delete();
        $this->account->recalculateBalance();

        session()->flash('success', 'Lançamento excluído com sucesso.');
    }

    public $editingTransactionId = null;
    public $editDescription = '';
    public $editCategoryId = '';
    public $editAmount = '';
    public $editDate = '';
    public $editType = '';
    public $editIsImported = false;

    public function editTransaction($id)
    {
        $tx = Transaction::findOrFail($id);
        
        $this->editingTransactionId = $tx->id;
        $this->editDescription = $tx->description;
        $this->editCategoryId = $tx->category_id;
        $this->editAmount = $tx->amount;
        $this->editDate = $tx->date->format('Y-m-d');
        $this->editType = $tx->type;
        $this->editIsImported = $tx->is_imported;
    }

    public function cancelEditTransaction()
    {
        $this->reset(['editingTransactionId', 'editDescription', 'editCategoryId', 'editAmount', 'editDate', 'editType', 'editIsImported']);
    }

    public function updateTransaction()
    {
        $tx = Transaction::findOrFail($this->editingTransactionId);

        // Security check
        if ($tx->account_id !== $this->account->id && $tx->to_account_id !== $this->account->id) {
            abort(403);
        }

        if ($tx->is_imported) {
            $this->validate([
                'editDescription' => 'required|string|max:255',
            ]);
            $tx->update([
                'description' => $this->editDescription,
                'category_id' => $this->editCategoryId ?: null,
            ]);
        } else {
             $this->validate([
                'editDescription' => 'required|string|max:255',
                'editAmount' => 'required|numeric|min:0.01',
                'editDate' => 'required|date',
                'editType' => 'required|in:income,expense',
            ]);

            // Update tx 
            $tx->update([
                 'description' => $this->editDescription,
                 'category_id' => $this->editCategoryId ?: null,
                 'amount' => $this->editAmount,
                 'date' => $this->editDate,
                 'type' => $this->editType,
            ]);

            $this->account->recalculateBalance();
        }

        $this->cancelEditTransaction();
        session()->flash('success', 'Lançamento atualizado com sucesso.');
    }

    public function exportData()
    {
        $transactions = Transaction::where(function ($query) {
                $query->where('account_id', $this->account->id)
                      ->orWhere('to_account_id', $this->account->id);
            })
            ->with(['category', 'toAccount'])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if ($transactions->isEmpty()) {
            session()->flash('error', 'Nenhuma movimentação para exportar.');
            return;
        }

        $csvFileName = "extrato_" . str()->slug($this->account->name) . "_" . now()->format('Ymd_His') . ".csv";

        return response()->streamDownload(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel formatting
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Header
            fputcsv($handle, ['Data', 'Descricao', 'Categoria', 'Tipo', 'Valor']);

            foreach ($transactions as $transaction) {
                
                $amountRaw = $transaction->amount;
                // If expense, show as negative
                if ($transaction->type === 'expense') {
                    $amountRaw = -abs($amountRaw);
                }

                $categoryName = 'Sem Categoria';
                if ($transaction->category) {
                    $categoryName = $transaction->category->name;
                } elseif ($transaction->to_account_id) {
                    $categoryName = 'Transferencia para ' . ($transaction->toAccount->name ?? 'Conta');
                }

                fputcsv($handle, [
                    $transaction->date->format('d/m/Y'),
                    $transaction->description,
                    $categoryName,
                    $transaction->type === 'expense' ? 'Saida' : 'Entrada',
                    number_format($amountRaw, 2, ',', '.') // Format PT-BR
                ]);
            }

            fclose($handle);
        }, $csvFileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        $transactions = Transaction::where(function ($query) {
                $query->where('account_id', $this->account->id)
                      ->orWhere('to_account_id', $this->account->id);
            })
            ->latest('date')
            ->latest('id')
            ->paginate(15);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $categories = Category::where('profile_id', $user->currentProfile()->id)
            ->orderBy('name')
            ->get();

        return view('livewire.account-show', [
            'transactions' => $transactions,
            'categories' => $categories
        ])->layout('layouts.app', ['header' => 'Detalhes da Conta']);
    }
}

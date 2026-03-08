<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class AccountShow extends Component
{
    use WithPagination;

    public Account $account;
    public $showForm = false;

    public function mount(Account $account)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

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
        // Placeholder handler
        $this->dispatch('import-modal-open');
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

        return view('livewire.account-show', [
            'transactions' => $transactions
        ])->layout('layouts.app', ['header' => 'Detalhes da Conta']);
    }
}

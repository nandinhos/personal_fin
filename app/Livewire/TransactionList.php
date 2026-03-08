<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TransactionList extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = '';
    public $accountFilter = '';

    #[On('transaction-saved')]
    public function refresh()
    {
        $this->resetPage();
    }

    public function delete($transactionId)
    {
        $user = Auth::user();
        $transaction = Transaction::where('profile_id', $user->currentProfile()->id)->findOrFail($transactionId);
        
        $accountId = $transaction->account_id;
        $toAccountId = $transaction->to_account_id;

        $transaction->delete();

        // Recalculate balances
        if ($accountId) {
            \App\Models\Account::find($accountId)?->recalculateBalance();
        }
        if ($toAccountId) {
            \App\Models\Account::find($toAccountId)?->recalculateBalance();
        }

        $this->dispatch('transaction-saved');
    }

    public function render()
    {
        $user = Auth::user();
        $profileId = $user->currentProfile()->id;

        $query = Transaction::where('profile_id', $profileId)
            ->with(['category', 'account', 'toAccount', 'card'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        if ($this->accountFilter) {
            $query->where(function($q) {
                $q->where('account_id', $this->accountFilter)
                  ->orWhere('to_account_id', $this->accountFilter);
            });
        }

        $transactions = $query->paginate(15);
        
        $accounts = \App\Models\Account::where('profile_id', $profileId)->orderBy('name')->get();
        $categories = \App\Models\Category::where('profile_id', $profileId)->orderBy('name')->get();

        return view('livewire.transaction-list', compact('transactions', 'accounts', 'categories'));
    }
}

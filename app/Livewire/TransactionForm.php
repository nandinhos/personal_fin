<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Card;
use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TransactionForm extends Component
{
    public $transactionId = null;
    
    // Form fields
    public $type = 'expense'; // expense, income, transfer
    public $account_id = '';
    public $to_account_id = '';
    public $card_id = '';
    public $category_id = '';
    public $amount = '';
    public $description = '';
    public $date = '';
    public $is_recurring = false;
    public $recurring_frequency = 'monthly';

    public function mount($transactionId = null)
    {
        $this->date = now()->format('Y-m-d');

        if ($transactionId) {
            $user = Auth::user();
            $transaction = Transaction::where('profile_id', $user->currentProfile()->id)->findOrFail($transactionId);
            
            $this->transactionId = $transaction->id;
            $this->type = $transaction->type;
            $this->account_id = $transaction->account_id;
            $this->to_account_id = $transaction->to_account_id;
            $this->card_id = $transaction->card_id;
            $this->category_id = $transaction->category_id;
            $this->amount = $transaction->amount;
            $this->description = $transaction->description;
            $this->date = $transaction->date->format('Y-m-d');
            $this->is_recurring = $transaction->is_recurring;
            $this->recurring_frequency = $transaction->recurring_frequency;
        }
    }

    protected function rules()
    {
        $rules = [
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|required_if:is_recurring,true',
        ];

        if ($this->type === 'transfer') {
            $rules['account_id'] = 'required|exists:accounts,id';
            $rules['to_account_id'] = 'required|exists:accounts,id|different:account_id';
            $rules['category_id'] = 'nullable';
        } else {
            $rules['category_id'] = 'required|exists:categories,id';
            $rules['account_id'] = 'nullable|required_without:card_id|exists:accounts,id';
            $rules['card_id'] = 'nullable|required_without:account_id|exists:cards,id';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $profileId = $user->currentProfile()->id;

        $data = [
            'profile_id' => $profileId,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
            'is_recurring' => $this->is_recurring,
            'recurring_frequency' => $this->is_recurring ? $this->recurring_frequency : null,
            'account_id' => $this->account_id ?: null,
            'to_account_id' => ($this->type === 'transfer') ? $this->to_account_id : null,
            'card_id' => ($this->type !== 'transfer') ? ($this->card_id ?: null) : null,
            'category_id' => ($this->type !== 'transfer') ? $this->category_id : null,
        ];

        if ($this->transactionId) {
            $transaction = Transaction::where('profile_id', $profileId)->findOrFail($this->transactionId);
            $transaction->update($data);
        } else {
            $transaction = Transaction::create($data);
        }

        // Recalculate balances if necessary
        if ($transaction->account_id) {
            $transaction->account->recalculateBalance();
        }
        if ($transaction->to_account_id) {
            $transaction->toAccount->recalculateBalance();
        }

        $this->dispatch('transaction-saved');
        session()->flash('success', $this->transactionId ? 'Transação atualizada!' : 'Transação registrada!');
    }

    public function render()
    {
        $user = Auth::user();
        $profileId = $user->currentProfile()->id;

        $accounts = Account::where('profile_id', $profileId)->orderBy('name')->get();
        $cards = Card::where('profile_id', $profileId)->orderBy('name')->get();
        $categories = Category::where('profile_id', $profileId)
            ->where('type', ($this->type === 'transfer' ? 'expense' : $this->type))
            ->orderBy('name')->get();

        return view('livewire.transaction-form', compact('accounts', 'cards', 'categories'));
    }
}

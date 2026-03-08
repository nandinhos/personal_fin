<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccountForm extends Component
{
    public $accountId = null;
    public $name = '';
    public $type = 'checking';
    public $initial_balance = 0.00;
    public $balance = 0.00;
    public $color = '#3B82F6';
    public $icon = 'wallet';

    public function mount($accountId = null)
    {
        if ($accountId) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $account = Account::where('profile_id', $user->currentProfile()->id)->findOrFail($accountId);
            $this->accountId = $account->id;
            $this->name = $account->name;
            $this->type = $account->type;
            $this->initial_balance = $account->initial_balance;
            $this->balance = $account->balance;
            $this->color = $account->color;
            $this->icon = $account->icon;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:checking,savings,investment,cash,other',
            'initial_balance' => 'required|numeric',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ];
    }

    public function updatedInitialBalance()
    {
        $this->validateOnly('initial_balance');
        
        if ($this->accountId) {
            $account = Account::findOrFail($this->accountId);
            // Temporary set to see what happens
            $this->balance = $this->initial_balance + ($account->balance - $account->initial_balance);
        } else {
            $this->balance = $this->initial_balance;
        }
    }

    public function recalculate()
    {
        if ($this->accountId) {
            $account = Account::findOrFail($this->accountId);
            $account->initial_balance = $this->initial_balance; // Sync with UI
            $this->balance = $account->recalculateBalance();
        }
    }

    public function save()
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profileId = $user->currentProfile()->id;

        if ($this->accountId) {
            $account = Account::where('profile_id', $profileId)->findOrFail($this->accountId);
            
            $account->update([
                'name' => $this->name,
                'type' => $this->type,
                'initial_balance' => $this->initial_balance,
                'color' => $this->color,
                'icon' => $this->icon,
            ]);
            
            // Forces official recalculation from transactions
            $this->balance = $account->recalculateBalance();
        } else {
            $account = Account::create([
                'profile_id' => $profileId,
                'name' => $this->name,
                'type' => $this->type,
                'initial_balance' => $this->initial_balance,
                'balance' => $this->initial_balance,
                'color' => $this->color,
                'icon' => $this->icon,
                'is_active' => true,
            ]);
            $this->balance = $account->balance;
        }

        $this->dispatch('account-saved');
        session()->flash('success', $this->accountId ? 'Conta atualizada!' : 'Conta criada!');
    }

    public function render()
    {
        return view('livewire.account-form');
    }
}

<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;

class AccountForm extends Component
{
    public $accountId = null;
    public $name = '';
    public $type = 'checking';
    public $balance = 0.00;
    public $color = '#3B82F6';
    public $icon = 'wallet';

    public function mount($accountId = null)
    {
        if ($accountId) {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            $account = Account::where('profile_id', $user->currentProfile()->id)->findOrFail($accountId);
            $this->accountId = $account->id;
            $this->name = $account->name;
            $this->type = $account->type;
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
            'balance' => 'required|numeric',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ];
    }

    public function save()
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $profileId = $user->currentProfile()->id;

        Account::updateOrCreate(
            ['id' => $this->accountId, 'profile_id' => $profileId],
            [
                'profile_id' => $profileId,
                'name' => $this->name,
                'type' => $this->type,
                'balance' => $this->balance,
                'color' => $this->color,
                'icon' => $this->icon,
                'is_active' => true,
            ]
        );

        $this->dispatch('account-saved');
        session()->flash('success', $this->accountId ? 'Conta atualizada!' : 'Conta criada!');
    }

    public function render()
    {
        return view('livewire.account-form');
    }
}

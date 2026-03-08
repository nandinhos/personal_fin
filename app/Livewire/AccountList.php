<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class AccountList extends Component
{
    use WithPagination;

    public function editAccount($id)
    {
        $this->dispatch('open-account-form', accountId: $id);
    }

    public function deleteAccount($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $account = Account::where('profile_id', $user->currentProfile()->id)->find($id);
        
        if ($account) {
            $account->delete();
            session()->flash('success', 'Conta excluída com sucesso.');
        }
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $accounts = Account::where('profile_id', $user->currentProfile()->id)
            ->latest()
            ->paginate(10);

        return view('livewire.account-list', [
            'accounts' => $accounts
        ]);
    }
}

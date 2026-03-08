<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class AccountManager extends Component
{
    public $showForm = false;
    public $editingAccountId = null;

    #[On('open-account-form')]
    public function openForm($accountId = null)
    {
        $this->editingAccountId = $accountId;
        $this->showForm = true;
    }

    #[On('account-saved')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingAccountId = null;
    }

    #[On('close-account-form')]
    public function cancelForm()
    {
        $this->showForm = false;
        $this->editingAccountId = null;
    }

    public function render()
    {
        return view('livewire.account-manager')
            ->layout('layouts.app', ['header' => 'Minhas Contas']);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class TransactionManager extends Component
{
    public $showForm = false;
    public $editingTransactionId = null;

    #[On('open-transaction-form')]
    public function openForm($transactionId = null)
    {
        $this->editingTransactionId = $transactionId;
        $this->showForm = true;
    }

    #[On('transaction-saved')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingTransactionId = null;
    }

    #[On('close-transaction-form')]
    public function cancelForm()
    {
        $this->showForm = false;
        $this->editingTransactionId = null;
    }

    public function render()
    {
        return view('livewire.transaction-manager')
            ->layout('layouts.app', ['header' => 'Minhas Transações']);
    }
}

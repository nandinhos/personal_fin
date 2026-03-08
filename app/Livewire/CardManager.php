<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CardManager extends Component
{
    public $showForm = false;
    public $editingCardId = null;

    #[On('open-card-form')]
    public function openForm($cardId = null)
    {
        $this->editingCardId = $cardId;
        $this->showForm = true;
    }

    #[On('card-saved')]
    public function closeForm()
    {
        $this->showForm = false;
        $this->editingCardId = null;
    }

    #[On('close-card-form')]
    public function cancelForm()
    {
        $this->showForm = false;
        $this->editingCardId = null;
    }

    public function render()
    {
        return view('livewire.card-manager')
            ->layout('layouts.app', ['header' => 'Meus Cartões']);
    }
}

<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CardList extends Component
{
    #[On('card-saved')]
    public function render()
    {
        $user = Auth::user();
        $cards = Card::where('profile_id', $user->currentProfile()->id)
            ->orderBy('name')
            ->get();

        return view('livewire.card-list', compact('cards'));
    }

    public function delete($cardId)
    {
        $user = Auth::user();
        $card = Card::where('profile_id', $user->currentProfile()->id)->findOrFail($cardId);
        $card->delete();
        
        $this->dispatch('card-saved'); // Refresh list
    }
}

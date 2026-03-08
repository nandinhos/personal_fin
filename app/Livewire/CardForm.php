<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CardForm extends Component
{
    public $cardId = null;
    public $name = '';
    public $type = 'credit';
    public $last_four_digits = '';
    public $limit = 0.00;
    public $closing_day = 5;
    public $due_day = 10;
    public $color = '#10B981'; // Emerald
    public $brand = 'Visa';

    public function mount($cardId = null)
    {
        if ($cardId) {
            $user = Auth::user();
            $card = Card::where('profile_id', $user->currentProfile()->id)->findOrFail($cardId);
            $this->cardId = $card->id;
            $this->name = $card->name;
            $this->type = $card->type;
            $this->last_four_digits = $card->last_four_digits;
            $this->limit = $card->limit;
            $this->closing_day = $card->closing_day;
            $this->due_day = $card->due_day;
            $this->color = $card->color;
            $this->brand = $card->brand;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:credit,debit',
            'last_four_digits' => 'required|string|size:4',
            'limit' => 'required|numeric|min:0',
            'closing_day' => 'nullable|integer|min:1|max:31',
            'due_day' => 'nullable|integer|min:1|max:31',
            'color' => 'nullable|string|max:7',
            'brand' => 'nullable|string|max:50',
        ];
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $profileId = $user->currentProfile()->id;

        $data = [
            'profile_id' => $profileId,
            'name' => $this->name,
            'type' => $this->type,
            'last_four_digits' => $this->last_four_digits,
            'limit' => $this->limit,
            'closing_day' => $this->closing_day,
            'due_day' => $this->due_day,
            'color' => $this->color,
            'brand' => $this->brand,
        ];

        if ($this->cardId) {
            $card = Card::where('profile_id', $profileId)->findOrFail($this->cardId);
            $card->update($data);
        } else {
            Card::create($data);
        }

        $this->dispatch('card-saved');
        session()->flash('success', $this->cardId ? 'Cartão atualizado!' : 'Cartão criado!');
    }

    public function render()
    {
        return view('livewire.card-form');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();

        return response()->json($cards);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:credit,debit',
            'last_four_digits' => 'required|string|size:4',
            'limit' => 'required|numeric',
            'closing_day' => 'nullable|integer|min:1|max:31',
            'due_day' => 'nullable|integer|min:1|max:31',
            'color' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        $card = Card::create($validated);

        return response()->json($card, 201);
    }

    public function show(Card $card)
    {
        return response()->json($card);
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:credit,debit',
            'last_four_digits' => 'sometimes|string|size:4',
            'limit' => 'sometimes|numeric',
            'closing_day' => 'nullable|integer|min:1|max:31',
            'due_day' => 'nullable|integer|min:1|max:31',
            'color' => 'nullable|string',
            'brand' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $card->update($validated);

        return response()->json($card);
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $cards = Card::where('profile_id', $profile->id)->get();

        if (request()->expectsJson()) {
            return response()->json($cards);
        }

        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        return view('cards.create');
    }

    public function store(Request $request)
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:credit,debit',
            'last_four_digits' => 'required|string|size:4',
            'limit' => 'required|numeric',
            'closing_day' => 'nullable|integer|min:1|max:31',
            'due_day' => 'nullable|integer|min:1|max:31',
            'color' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        $validated['profile_id'] = $profile->id;

        $card = Card::create($validated);

        if ($request->expectsJson()) {
            return response()->json($card, 201);
        }

        return redirect()->route('cards.index')->with('success', 'Cartão criado com sucesso!');
    }

    public function show(Card $card)
    {
        abort_if($card->profile->user_id !== auth()->id(), 403);

        return response()->json($card);
    }

    public function update(Request $request, Card $card)
    {
        abort_if($card->profile->user_id !== auth()->id(), 403);

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
        abort_if($card->profile->user_id !== auth()->id(), 403);

        $card->delete();

        return response()->json(null, 204);
    }
}

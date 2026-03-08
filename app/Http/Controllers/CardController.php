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
        $this->authorize('view', $card);

        return response()->json($card);
    }

    public function update(Request $request, Card $card)
    {
        $this->authorize('update', $card);

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

        if (!$request->has('is_active') && $request->isMethod('PUT')) {
            $validated['is_active'] = false;
        }

        $card->update($validated);

        if ($request->expectsJson()) {
            return response()->json($card);
        }

        return redirect()->route('cards.index')->with('success', 'Cartão atualizado com sucesso!');
    }

    public function destroy(Request $request, Card $card)
    {
        $this->authorize('delete', $card);

        $card->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('cards.index')->with('success', 'Cartão excluído com sucesso!');
    }
}

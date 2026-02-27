<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profiles()->first();

        if (! $profile) {
            return request()->expectsJson()
                ? response()->json([])
                : view('accounts.index', ['accounts' => collect()]);
        }

        $accounts = Account::where('profile_id', $profile->id)->get();

        if (request()->expectsJson()) {
            return response()->json($accounts);
        }

        return view('accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Padrão', 'is_default' => true]
        );

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,investment,cash,other',
            'balance' => 'required|numeric',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $validated['profile_id'] = $profile->id;

        $account = Account::create($validated);

        return response()->json($account, 201);
    }

    public function show(Account $account)
    {
        abort_if($account->profile->user_id !== auth()->id(), 403);

        return response()->json($account);
    }

    public function update(Request $request, Account $account)
    {
        abort_if($account->profile->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:checking,savings,investment,cash,other',
            'balance' => 'sometimes|numeric',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $account->update($validated);

        return response()->json($account);
    }

    public function destroy(Account $account)
    {
        abort_if($account->profile->user_id !== auth()->id(), 403);

        $account->delete();

        return response()->json(null, 204);
    }
}

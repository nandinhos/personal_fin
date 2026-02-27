<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,investment,cash,other',
            'balance' => 'required|numeric',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $account = Account::create($validated);

        return response()->json($account, 201);
    }

    public function show(Account $account)
    {
        return response()->json($account);
    }

    public function update(Request $request, Account $account)
    {
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
        $account->delete();

        return response()->json(null, 204);
    }
}

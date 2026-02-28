<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Card;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $profile = auth()->user()->profiles()->first();

        $query = Transaction::query()->where('profile_id', $profile?->id ?? 0);

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->has('card_id')) {
            $query->where('card_id', $request->card_id);
        }

        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $transactions = $query->with(['category', 'account', 'toAccount', 'card'])
            ->orderBy('date', 'desc')
            ->get();

        if ($request->expectsJson()) {
            return response()->json($transactions);
        }

        $categories = $profile ? Category::where('profile_id', $profile->id)->get() : collect();
        $accounts = $profile ? Account::where('profile_id', $profile->id)->get() : collect();

        return view('transactions.index', compact('transactions', 'categories', 'accounts'));
    }

    public function create()
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $categories = Category::where('profile_id', $profile->id)->get();
        $accounts = Account::where('profile_id', $profile->id)->get();
        $cards = Card::where('profile_id', $profile->id)->get();

        return view('transactions.create', compact('categories', 'accounts', 'cards'));
    }

    public function store(Request $request)
    {
        $profile = auth()->user()->profiles()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => 'Principal', 'is_default' => true]
        );

        $rules = [
            'account_id' => 'nullable|exists:accounts,id',
            'card_id' => 'nullable|exists:cards,id',
            'to_account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|string',
        ];

        if ($request->type === 'transfer') {
            $rules['account_id'] = 'required|exists:accounts,id|different:to_account_id';
            $rules['to_account_id'] = 'required|exists:accounts,id';
            $rules['category_id'] = 'nullable';
        } else {
            $rules['category_id'] = 'required|exists:categories,id';
        }

        $validated = $request->validate($rules);

        $validated['profile_id'] = $profile->id;

        if ($request->type === 'transfer') {
            $validated['transfer_type'] = 'transfer';
            unset($validated['category_id']);
        }

        $transaction = Transaction::create($validated);

        if ($request->type === 'transfer' && $validated['account_id'] && $validated['to_account_id']) {
            $fromAccount = Account::find($validated['account_id']);
            $toAccount = Account::find($validated['to_account_id']);

            if ($fromAccount) {
                $fromAccount->balance -= $validated['amount'];
                $fromAccount->save();
            }
            if ($toAccount) {
                $toAccount->balance += $validated['amount'];
                $toAccount->save();
            }
        } elseif ($request->type === 'income' && $validated['account_id']) {
            $account = Account::find($validated['account_id']);
            if ($account) {
                $account->balance += $validated['amount'];
                $account->save();
            }
        } elseif ($request->type === 'expense' && $validated['account_id']) {
            $account = Account::find($validated['account_id']);
            if ($account) {
                $account->balance -= $validated['amount'];
                $account->save();
            }
        }

        if ($request->expectsJson()) {
            return response()->json($transaction->load('category'), 201);
        }

        return redirect()->route('transactions.index')->with('success', 'Transação criada com sucesso!');
    }

    public function show(Transaction $transaction): JsonResponse
    {
        abort_if($transaction->profile->user_id !== auth()->id(), 403);

        return response()->json($transaction->load(['category', 'account', 'card']));
    }

    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        abort_if($transaction->profile->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'account_id' => 'nullable|exists:accounts,id',
            'card_id' => 'nullable|exists:cards,id',
            'type' => 'sometimes|in:income,expense',
            'amount' => 'sometimes|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'sometimes|date',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return response()->json($transaction);
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        abort_if($transaction->profile->user_id !== auth()->id(), 403);

        $transaction->delete();

        return response()->json(null, 204);
    }
}

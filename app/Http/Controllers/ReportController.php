<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function expensesByCategory(Request $request)
    {
        $profileId = $request->user()->profile->id ?? 1;

        $expenses = Transaction::where('profile_id', $profileId)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return response()->json($expenses);
    }

    public function incomeVsExpense(Request $request)
    {
        $profileId = $request->user()->profile->id ?? 1;

        $income = Transaction::where('profile_id', $profileId)
            ->where('type', 'income')
            ->sum('amount');

        $expense = Transaction::where('profile_id', $profileId)
            ->where('type', 'expense')
            ->sum('amount');

        return response()->json([
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ]);
    }

    public function monthly(Request $request)
    {
        $profileId = $request->user()->profile->id ?? 1;

        $monthly = Transaction::where('profile_id', $profileId)
            ->select(
                DB::raw('EXTRACT(YEAR FROM date) as year'),
                DB::raw('EXTRACT(MONTH FROM date) as month'),
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year', 'month', 'type')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json($monthly);
    }

    public function byCard(Request $request)
    {
        $profileId = $request->user()->profile->id ?? 1;

        $byCard = Transaction::where('profile_id', $profileId)
            ->whereNotNull('card_id')
            ->select('card_id', DB::raw('SUM(amount) as total'))
            ->groupBy('card_id')
            ->with('card')
            ->get();

        return response()->json($byCard);
    }

    public function byAccount(Request $request)
    {
        $profileId = $request->user()->profile->id ?? 1;

        $byAccount = Transaction::where('profile_id', $profileId)
            ->whereNotNull('account_id')
            ->select('account_id', DB::raw('SUM(amount) as total'))
            ->groupBy('account_id')
            ->with('account')
            ->get();

        return response()->json($byAccount);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Goal;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $profile = $user->profile ?? null;

        $totalBalance = 0;
        $monthlyIncome = 0;
        $monthlyExpenses = 0;
        $goalsProgress = 0;
        $recentTransactions = [];
        $monthlyLimitUsed = 0;
        $monthlyLimitAvailable = 0;
        $monthlyLimitPercent = 0;

        if ($profile) {
            $totalBalance = Account::where('profile_id', $profile->id)
                ->where('is_active', true)
                ->sum('balance');

            $currentMonth = now()->month;
            $currentYear = now()->year;

            $monthlyIncome = Transaction::where('profile_id', $profile->id)
                ->where('type', 'income')
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $monthlyExpenses = Transaction::where('profile_id', $profile->id)
                ->where('type', 'expense')
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $goals = Goal::where('profile_id', $profile->id)
                ->where('is_completed', false)
                ->get();

            if ($goals->isNotEmpty()) {
                $totalTarget = $goals->sum('target_amount');
                $totalCurrent = $goals->sum('current_amount');
                $goalsProgress = $totalTarget > 0 ? (int) (($totalCurrent / $totalTarget) * 100) : 0;
            }

            $transactions = Transaction::where('profile_id', $profile->id)
                ->with('category')
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $recentTransactions = $transactions->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->description ?? $t->category->name ?? 'Transação',
                    'category' => $t->category->name ?? 'Sem categoria',
                    'amount' => $t->type === 'expense' ? -$t->amount : $t->amount,
                    'date' => $t->date->format('d/m/Y'),
                    'type' => $t->type,
                ];
            })->toArray();

            $defaultLimit = 5000;
            $monthlyLimitUsed = $monthlyExpenses;
            $monthlyLimitAvailable = max(0, $defaultLimit - $monthlyLimitUsed);
            $monthlyLimitPercent = $defaultLimit > 0 ? (int) (($monthlyLimitUsed / $defaultLimit) * 100) : 0;
        }

        return view('livewire.dashboard', compact(
            'totalBalance', 'monthlyIncome', 'monthlyExpenses',
            'goalsProgress', 'recentTransactions', 'monthlyLimitUsed',
            'monthlyLimitAvailable', 'monthlyLimitPercent'
        ));
    }
}

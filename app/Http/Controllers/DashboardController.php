<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Goal;
use App\Models\Limit;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        $profile = Auth::user()->profiles()->first();

        if (! $profile) {
            return response()->json([
                'total_balance'          => 0,
                'monthly_income'         => 0,
                'monthly_expenses'       => 0,
                'goals_progress'         => 0,
                'monthly_limit_used'     => 0,
                'monthly_limit_total'    => 0,
                'monthly_limit_percent'  => 0,
                'recent_transactions'    => [],
            ]);
        }

        $currentMonth = now()->month;
        $currentYear  = now()->year;

        $totalBalance = Account::where('profile_id', $profile->id)
            ->where('is_active', true)
            ->sum('balance');

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

        // Progresso de metas
        $goals = Goal::where('profile_id', $profile->id)
            ->where('is_completed', false)
            ->get();

        $goalsProgress = 0;
        if ($goals->isNotEmpty()) {
            $totalTarget  = $goals->sum('target_amount');
            $totalCurrent = $goals->sum('current_amount');
            $goalsProgress = $totalTarget > 0 ? (int) (($totalCurrent / $totalTarget) * 100) : 0;
        }

        // Limite mensal real (soma dos limites mensais ativos do perfil)
        $monthlyLimitTotal = Limit::where('profile_id', $profile->id)
            ->where('is_active', true)
            ->where('period', 'monthly')
            ->sum('amount');

        $monthlyLimitPercent = $monthlyLimitTotal > 0
            ? (int) (($monthlyExpenses / $monthlyLimitTotal) * 100)
            : 0;

        // Últimas 5 transações
        $recentTransactions = Transaction::where('profile_id', $profile->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($t) => [
                'id'       => $t->id,
                'name'     => $t->description ?? $t->category?->name ?? 'Transação',
                'category' => $t->category?->name ?? 'Sem categoria',
                'amount'   => $t->type === 'expense' ? -$t->amount : $t->amount,
                'date'     => $t->date->format('d/m/Y'),
                'type'     => $t->type,
            ]);

        return response()->json([
            'total_balance'         => (float) $totalBalance,
            'monthly_income'        => (float) $monthlyIncome,
            'monthly_expenses'      => (float) $monthlyExpenses,
            'goals_progress'        => $goalsProgress,
            'monthly_limit_used'    => (float) $monthlyExpenses,
            'monthly_limit_total'   => (float) $monthlyLimitTotal,
            'monthly_limit_percent' => $monthlyLimitPercent,
            'recent_transactions'   => $recentTransactions,
        ]);
    }
}

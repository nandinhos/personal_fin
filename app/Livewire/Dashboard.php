<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Goal;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalBalance = 0;

    public $monthlyIncome = 0;

    public $monthlyExpenses = 0;

    public $goalsProgress = 0;

    public $recentTransactions = [];

    public $monthlyLimitUsed = 0;

    public $monthlyLimitAvailable = 0;

    public $monthlyLimitPercent = 0;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user();
        $profile = $user->profile ?? null;

        if (! $profile) {
            return;
        }

        $this->loadBalance($profile);
        $this->loadMonthlyTotals($profile);
        $this->loadGoalsProgress($profile);
        $this->loadRecentTransactions($profile);
        $this->loadMonthlyLimit($profile);
    }

    protected function loadBalance($profile)
    {
        $this->totalBalance = Account::where('profile_id', $profile->id)
            ->where('is_active', true)
            ->sum('balance');
    }

    protected function loadMonthlyTotals($profile)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $this->monthlyIncome = Transaction::where('profile_id', $profile->id)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $this->monthlyExpenses = Transaction::where('profile_id', $profile->id)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
    }

    protected function loadGoalsProgress($profile)
    {
        $goals = Goal::where('profile_id', $profile->id)
            ->where('is_completed', false)
            ->get();

        if ($goals->isEmpty()) {
            $this->goalsProgress = 0;

            return;
        }

        $totalTarget = $goals->sum('target_amount');
        $totalCurrent = $goals->sum('current_amount');

        $this->goalsProgress = $totalTarget > 0
            ? (int) (($totalCurrent / $totalTarget) * 100)
            : 0;
    }

    protected function loadRecentTransactions($profile)
    {
        $transactions = Transaction::where('profile_id', $profile->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        $this->recentTransactions = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'name' => $transaction->description ?? $transaction->category->name ?? 'Transação',
                'category' => $transaction->category->name ?? 'Sem categoria',
                'amount' => $transaction->type === 'expense' ? -$transaction->amount : $transaction->amount,
                'date' => $transaction->date->format('d/m/Y'),
                'type' => $transaction->type,
            ];
        })->toArray();
    }

    protected function loadMonthlyLimit($profile)
    {
        $defaultLimit = 5000;
        $this->monthlyLimitUsed = $this->monthlyExpenses;
        $this->monthlyLimitAvailable = max(0, $defaultLimit - $this->monthlyLimitUsed);
        $this->monthlyLimitPercent = $defaultLimit > 0
            ? (int) (($this->monthlyLimitUsed / $defaultLimit) * 100)
            : 0;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

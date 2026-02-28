<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
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

    public $showQuickTransactionModal = false;

    public $quickTransactionType = 'expense';

    public $quickForm = [
        'description' => '',
        'amount' => '',
        'category_id' => '',
        'account_id' => '',
        'to_account_id' => '',
        'date' => '',
        'type' => 'expense',
    ];

    public $categories = [];

    public $accounts = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user();
        $profile = $user->profiles()->first() ?? null;

        if (! $profile) {
            return;
        }

        $this->loadBalance($profile);
        $this->loadMonthlyTotals($profile);
        $this->loadGoalsProgress($profile);
        $this->loadRecentTransactions($profile);
        $this->loadMonthlyLimit($profile);
        $this->loadCategoriesAndAccounts($profile);
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
            $date = $transaction->date;
            if (is_string($date)) {
                $date = \Carbon\Carbon::parse($date);
            }

            return [
                'id' => $transaction->id,
                'name' => $transaction->description ?? $transaction->category->name ?? 'Transação',
                'category' => $transaction->category->name ?? 'Sem categoria',
                'amount' => $transaction->type === 'expense' ? -$transaction->amount : $transaction->amount,
                'date' => $date->format('d/m/Y'),
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

    protected function loadCategoriesAndAccounts($profile)
    {
        $this->categories = Category::where('profile_id', $profile->id)
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->accounts = Account::where('profile_id', $profile->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function openQuickTransactionModal($type = 'expense')
    {
        $this->quickTransactionType = $type;
        $this->quickForm = [
            'description' => '',
            'amount' => '',
            'category_id' => '',
            'account_id' => $this->accounts[0]['id'] ?? '',
            'to_account_id' => '',
            'date' => now()->format('Y-m-d'),
            'type' => $type,
        ];
        $this->showQuickTransactionModal = true;
    }

    public function closeQuickTransactionModal()
    {
        $this->showQuickTransactionModal = false;
        $this->reset('quickForm');
    }

    public function saveQuickTransaction()
    {
        $user = Auth::user();
        $profile = $user->profiles()->first();

        if (! $profile) {
            return;
        }

        $rules = [
            'quickForm.description' => 'required|string|max:255',
            'quickForm.amount' => 'required|numeric|min:0.01',
            'quickForm.account_id' => 'required|exists:accounts,id',
            'quickForm.date' => 'required|date',
            'quickForm.type' => 'required|in:income,expense,transfer',
        ];

        if ($this->quickForm['type'] === 'transfer') {
            $rules['quickForm.to_account_id'] = 'required|exists:accounts,id|different:quickForm.account_id';
        } else {
            $rules['quickForm.category_id'] = 'required|exists:categories,id';
        }

        $validated = $this->validate($rules);

        $transactionData = [
            'profile_id' => $profile->id,
            'description' => $validated['quickForm']['description'],
            'amount' => $validated['quickForm']['amount'],
            'account_id' => $validated['quickForm']['account_id'],
            'date' => $validated['quickForm']['date'],
            'type' => $validated['quickForm']['type'],
        ];

        if ($validated['quickForm']['type'] === 'transfer') {
            $transactionData['to_account_id'] = $validated['quickForm']['to_account_id'];
            $transactionData['transfer_type'] = 'transfer';
            $transactionData['category_id'] = null;
        } else {
            $transactionData['category_id'] = $validated['quickForm']['category_id'];
        }

        Transaction::create($transactionData);

        if ($validated['quickForm']['type'] === 'transfer') {
            $fromAccount = \App\Models\Account::find($validated['quickForm']['account_id']);
            $toAccount = \App\Models\Account::find($validated['quickForm']['to_account_id']);
            if ($fromAccount) {
                $fromAccount->balance -= $validated['quickForm']['amount'];
                $fromAccount->save();
            }
            if ($toAccount) {
                $toAccount->balance += $validated['quickForm']['amount'];
                $toAccount->save();
            }
        } else {
            $account = \App\Models\Account::find($validated['quickForm']['account_id']);
            if ($account) {
                if ($validated['quickForm']['type'] === 'income') {
                    $account->balance += $validated['quickForm']['amount'];
                } else {
                    $account->balance -= $validated['quickForm']['amount'];
                }
                $account->save();
            }
        }

        $this->closeQuickTransactionModal();
        $this->loadData();

        $this->dispatch('notify', [
            'message' => 'Transação salva com sucesso!',
            'type' => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dev\ApiCatalogController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard-wrapper');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/categories/manager', function () {
    return view('categories.manager');
})->middleware('auth')->name('categories.manager');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard API
    Route::get('/dashboard/summary', [App\Http\Controllers\DashboardController::class, 'summary'])->name('dashboard.summary');

    // Contas
    Route::resource('accounts', AccountController::class)
        ->except(['create', 'edit'])
        ->parameters(['accounts' => 'account']);

    // Cartões — fix crítico: create/edit não existem no controller
    Route::resource('cards', CardController::class)
        ->except(['create', 'edit'])
        ->parameters(['cards' => 'card']);

    // Transações
    Route::resource('transactions', TransactionController::class)
        ->except(['create', 'edit'])
        ->parameters(['transactions' => 'transaction']);

    // Categorias e subcategorias
    Route::resource('categories', CategoryController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['categories' => 'category']);

    Route::resource('subcategories', SubcategoryController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['subcategories' => 'subcategory']);

    // Limites
    Route::resource('limits', LimitController::class)
        ->except(['show', 'create', 'edit'])
        ->parameters(['limits' => 'limit']);

    // Metas — fix: rota progress registrada
    Route::resource('goals', GoalController::class)
        ->except(['show', 'create', 'edit'])
        ->parameters(['goals' => 'goal']);
    Route::patch('/goals/{goal}/progress', [GoalController::class, 'updateProgress'])->name('goals.progress');

    // Parcelas
    Route::get('/installments/pending', [InstallmentController::class, 'pending'])->name('installments.pending');
    Route::patch('/installments/{installment}/pay', [InstallmentController::class, 'pay'])->name('installments.pay');
    Route::resource('installments', InstallmentController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['installments' => 'installment']);

    // Investimentos
    Route::get('/investments/summary', [InvestmentController::class, 'summary'])->name('investments.summary');
    Route::resource('investments', InvestmentController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['investments' => 'investment']);

    // Empréstimos
    Route::patch('/loans/{loan}/pay', [LoanController::class, 'pay'])->name('loans.pay');
    Route::resource('loans', LoanController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['loans' => 'loan']);

    // Relatórios
    Route::get('/reports/expenses-by-category', [ReportController::class, 'expensesByCategory']);
    Route::get('/reports/income-expense', [ReportController::class, 'incomeVsExpense']);
    Route::get('/reports/monthly', [ReportController::class, 'monthly']);
    Route::get('/reports/by-card', [ReportController::class, 'byCard']);
    Route::get('/reports/by-account', [ReportController::class, 'byAccount']);

    // Área Dev — admin only
    Route::middleware('admin')->prefix('dev')->name('dev.')->group(function () {
        Route::get('/', fn () => redirect()->route('dev.catalog'))->name('home');
        Route::get('/catalog', [ApiCatalogController::class, 'index'])->name('catalog');
        Route::post('/catalog/probe', [ApiCatalogController::class, 'probe'])->name('catalog.probe');
    });
});

require __DIR__.'/auth.php';

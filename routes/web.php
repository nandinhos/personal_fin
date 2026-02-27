<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('accounts', AccountController::class)->parameters([
        'accounts' => 'account',
    ]);
    Route::resource('cards', CardController::class)->parameters([
        'cards' => 'card',
    ]);
    Route::resource('transactions', TransactionController::class)->parameters([
        'transactions' => 'transaction',
    ]);
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category',
    ]);
    Route::resource('subcategories', SubcategoryController::class)->parameters([
        'subcategories' => 'subcategory',
    ]);

    Route::get('/reports/expenses-by-category', [ReportController::class, 'expensesByCategory']);
    Route::get('/reports/income-expense', [ReportController::class, 'incomeVsExpense']);
    Route::get('/reports/monthly', [ReportController::class, 'monthly']);
    Route::get('/reports/by-card', [ReportController::class, 'byCard']);
    Route::get('/reports/by-account', [ReportController::class, 'byAccount']);
});

require __DIR__.'/auth.php';

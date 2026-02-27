<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('accounts', AccountController::class)
        ->except(['create', 'edit'])
        ->parameters(['accounts' => 'account']);

    Route::resource('cards', CardController::class)
        ->except(['create', 'edit'])
        ->parameters(['cards' => 'card']);

    Route::resource('transactions', TransactionController::class)
        ->except(['edit'])
        ->parameters(['transactions' => 'transaction']);

    Route::resource('categories', CategoryController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['categories' => 'category']);

    Route::resource('subcategories', SubcategoryController::class)
        ->except(['create', 'edit', 'show'])
        ->parameters(['subcategories' => 'subcategory']);

    Route::get('/reports/expenses-by-category', [ReportController::class, 'expensesByCategory']);
    Route::get('/reports/income-expense', [ReportController::class, 'incomeVsExpense']);
    Route::get('/reports/monthly', [ReportController::class, 'monthly']);
    Route::get('/reports/by-card', [ReportController::class, 'byCard']);
    Route::get('/reports/by-account', [ReportController::class, 'byAccount']);
});

require __DIR__.'/auth.php';

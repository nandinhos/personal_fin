<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_can_be_created(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $transaction = Transaction::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 150.50,
            'description' => 'Compra no supermercado',
            'date' => now(),
        ]);

        $this->assertDatabaseHas('transactions', [
            'amount' => 150.50,
            'description' => 'Compra no supermercado',
        ]);
    }

    public function test_transaction_belongs_to_profile(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $transaction = Transaction::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 100.00,
            'date' => now(),
        ]);

        $this->assertInstanceOf(Profile::class, $transaction->profile);
    }

    public function test_transaction_belongs_to_category(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $transaction = Transaction::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 100.00,
            'date' => now(),
        ]);

        $this->assertInstanceOf(Category::class, $transaction->category);
    }

    public function test_transaction_can_be_income_or_expense(): void
    {
        $profile = Profile::factory()->create();
        $incomeCategory = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'income']);
        $expenseCategory = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $income = Transaction::create([
            'profile_id' => $profile->id,
            'category_id' => $incomeCategory->id,
            'type' => 'income',
            'amount' => 5000.00,
            'date' => now(),
        ]);

        $expense = Transaction::create([
            'profile_id' => $profile->id,
            'category_id' => $expenseCategory->id,
            'type' => 'expense',
            'amount' => 150.00,
            'date' => now(),
        ]);

        $this->assertEquals('income', $income->type);
        $this->assertEquals('expense', $expense->type);
    }
}

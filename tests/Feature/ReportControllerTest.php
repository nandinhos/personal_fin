<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_expenses_by_category(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        Transaction::factory()->count(3)->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 100.00,
        ]);

        $response = $this->actingAs($user)->get('/reports/expenses-by-category');

        $response->assertStatus(200);
    }

    public function test_can_get_income_vs_expense(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $incomeCategory = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'income']);
        $expenseCategory = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $incomeCategory->id,
            'type' => 'income',
            'amount' => 5000.00,
        ]);

        Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $expenseCategory->id,
            'type' => 'expense',
            'amount' => 2000.00,
        ]);

        $response = $this->actingAs($user)->get('/reports/income-expense');

        $response->assertStatus(200);
    }

    public function test_can_get_monthly_summary(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id]);

        Transaction::factory()->count(5)->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get('/reports/monthly');

        $response->assertStatus(200);
    }
}

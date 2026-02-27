<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_transactions(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        Transaction::factory()->count(3)->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get('/transactions');

        $response->assertStatus(200);
    }

    public function test_can_create_transaction(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->post('/transactions', [
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'type' => 'expense',
            'amount' => 150.50,
            'description' => 'Compra no mercado',
            'date' => now()->toDateString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('transactions', ['amount' => 150.50]);
    }

    public function test_can_update_transaction(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        $transaction = Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->put("/transactions/{$transaction->id}", [
            'amount' => 200.00,
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', ['amount' => 200.00]);
    }

    public function test_can_delete_transaction(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['profile_id' => $profile->id]);
        $transaction = Transaction::factory()->create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->delete("/transactions/{$transaction->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('transactions', ['id' => $transaction->id]);
    }
}

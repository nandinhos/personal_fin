<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_accounts(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        Account::factory()->count(3)->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->get('/accounts');

        $response->assertStatus(200);
    }

    public function test_can_create_account(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/accounts', [
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'checking',
            'balance' => 5000.00,
            'color' => '#820AD1',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('accounts', ['name' => 'Nubank']);
    }

    public function test_can_update_account(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $account = Account::factory()->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->put("/accounts/{$account->id}", [
            'name' => 'Nubank Updated',
            'type' => 'savings',
            'balance' => 6000.00,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('accounts', ['name' => 'Nubank Updated']);
    }

    public function test_can_delete_account(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $account = Account::factory()->create(['profile_id' => $profile->id]);

        $response = $this->actingAs($user)->delete("/accounts/{$account->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('accounts', ['id' => $account->id]);
    }
}

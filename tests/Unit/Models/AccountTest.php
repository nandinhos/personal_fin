<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_can_be_created(): void
    {
        $profile = Profile::factory()->create();

        $account = Account::create([
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'checking',
            'balance' => 5000.00,
            'color' => '#820AD1',
        ]);

        $this->assertDatabaseHas('accounts', [
            'name' => 'Nubank',
            'type' => 'checking',
            'balance' => 5000.00,
        ]);
    }

    public function test_account_belongs_to_profile(): void
    {
        $profile = Profile::factory()->create();

        $account = Account::create([
            'profile_id' => $profile->id,
            'name' => 'Nubank',
            'type' => 'checking',
            'balance' => 5000.00,
        ]);

        $this->assertInstanceOf(Profile::class, $account->profile);
    }

    public function test_account_has_valid_types(): void
    {
        $profile = Profile::factory()->create();

        $checking = Account::create([
            'profile_id' => $profile->id,
            'name' => 'Conta Corrente',
            'type' => 'checking',
            'balance' => 1000.00,
        ]);

        $savings = Account::create([
            'profile_id' => $profile->id,
            'name' => 'Poupança',
            'type' => 'savings',
            'balance' => 2000.00,
        ]);

        $this->assertEquals('checking', $checking->type);
        $this->assertEquals('savings', $savings->type);
    }
}

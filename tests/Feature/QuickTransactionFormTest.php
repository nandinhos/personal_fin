<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuickTransactionFormTest extends TestCase
{
    use RefreshDatabase;

    private \App\Models\User $user;
    private \App\Models\Profile $profile;
    private \App\Models\Account $account;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = \App\Models\User::factory()->create();
        $this->profile = \App\Models\Profile::factory()->create(['user_id' => $this->user->id]);
        $this->user->update(['current_profile_id' => $this->profile->id]);

        $this->account = \App\Models\Account::factory()->create([
            'profile_id' => $this->profile->id,
            'type' => 'checking',
            'balance' => 0,
        ]);
    }

    public function test_can_save_quick_income_transaction(): void
    {
        \Livewire\Livewire::actingAs($this->user)
            ->test(\App\Livewire\QuickTransactionForm::class, ['accountId' => $this->account->id])
            ->set('type', 'income')
            ->set('amount', 55.50)
            ->set('date', '2026-03-08')
            ->set('description', 'Salario')
            ->call('save')
            ->assertDispatched('account-saved');

        $this->assertDatabaseHas('transactions', [
            'account_id' => $this->account->id,
            'type' => 'income',
            'amount' => 55.50,
            'description' => 'Salario',
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $this->account->id,
            'balance' => 55.50,
        ]);
    }

    public function test_can_save_quick_expense_transaction(): void
    {
        \Livewire\Livewire::actingAs($this->user)
            ->test(\App\Livewire\QuickTransactionForm::class, ['accountId' => $this->account->id])
            ->set('type', 'expense')
            ->set('amount', 30.00)
            ->set('date', '2026-03-08')
            ->set('description', 'Almoco')
            ->call('save')
            ->assertDispatched('account-saved');

        $this->assertDatabaseHas('transactions', [
            'account_id' => $this->account->id,
            'type' => 'expense',
            'amount' => 30.00,
            'description' => 'Almoco',
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $this->account->id,
            'balance' => -30.00,
        ]);
    }
}

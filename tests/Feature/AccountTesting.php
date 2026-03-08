<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Account;
use Livewire\Livewire;
use App\Livewire\AccountManager;
use App\Livewire\AccountList;
use App\Livewire\AccountForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTesting extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->profile = Profile::factory()->create(['user_id' => $this->user->id]);
        $this->user->update(['current_profile_id' => $this->profile->id]);
    }

    public function test_renders_the_account_manager_dashboard(): void
    {
        $this->actingAs($this->user)
            ->get(route('accounts.index'))
            ->assertStatus(200)
            ->assertSeeLivewire(AccountManager::class)
            ->assertSeeLivewire(AccountList::class);
    }

    public function test_lists_existing_accounts(): void
    {
        Account::factory()->create([
            'profile_id' => $this->profile->id,
            'name' => 'Nubank Test',
            'balance' => 150.00,
            'type' => 'checking',
        ]);

        Livewire::actingAs($this->user)
            ->test(AccountList::class)
            ->assertSee('Nubank Test');
    }

    public function test_can_create_a_new_account_via_form(): void
    {
        Livewire::actingAs($this->user)
            ->test(AccountForm::class)
            ->set('name', 'Nova Carteira')
            ->set('type', 'cash')
            ->set('balance', 100.50)
            ->call('save')
            ->assertDispatched('account-saved');

        $this->assertDatabaseHas('accounts', [
            'profile_id' => $this->profile->id,
            'name' => 'Nova Carteira',
            'balance' => 100.50
        ]);
    }

    public function test_can_delete_an_account(): void
    {
        $account = Account::factory()->create([
            'profile_id' => $this->profile->id,
            'type' => 'checking',
        ]);

        Livewire::actingAs($this->user)
            ->test(AccountList::class)
            ->call('deleteAccount', $account->id);

        $this->assertSoftDeleted('accounts', [
            'id' => $account->id,
        ]);
    }

    public function test_renders_the_account_show_dashboard(): void
    {
        $account = Account::factory()->create([
            'profile_id' => $this->profile->id,
            'type' => 'checking',
            'name' => 'Nubank Show',
        ]);

        $this->actingAs($this->user)
            ->get(route('accounts.show', $account->id))
            ->assertStatus(200)
            ->assertSee('Nubank Show')
            ->assertSeeLivewire(\App\Livewire\AccountShow::class)
            ->assertSeeLivewire(\App\Livewire\AccountImportForm::class);
    }

    public function test_can_export_account_transactions_to_csv(): void
    {
        $account = Account::factory()->create([
            'profile_id' => $this->profile->id,
            'type' => 'checking',
        ]);

        \App\Models\Transaction::factory()->create([
            'profile_id' => $this->profile->id,
            'account_id' => $account->id,
            'type' => 'expense',
            'amount' => 100.00,
            'description' => 'Mercado Teste'
        ]);

        Livewire::actingAs($this->user)
            ->test(\App\Livewire\AccountShow::class, ['account' => $account])
            ->call('exportData')
            ->assertFileDownloaded();
    }
}

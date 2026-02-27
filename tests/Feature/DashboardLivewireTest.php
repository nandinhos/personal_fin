<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_route_returns_view(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_dashboard_displays_balance_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Saldo Total', false);
    }

    public function test_dashboard_displays_income_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Receitas', false);
    }

    public function test_dashboard_displays_expense_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Despesas', false);
    }

    public function test_dashboard_displays_recent_transactions(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Transações Recentes', false);
    }

    public function test_dashboard_displays_quick_actions(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Ações Rápidas', false);
    }

    public function test_dashboard_displays_monthly_limit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('Limite Mensal', false);
    }
}

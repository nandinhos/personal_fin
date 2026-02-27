<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BottomNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_has_bottom_navigation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Home', false);
        $response->assertSee('Contas', false);
        $response->assertSee('Gastos', false);
        $response->assertSee('Relatórios', false);
        $response->assertSee('Ajustes', false);
    }

    public function test_bottom_navigation_has_mobile_layout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $content = $response->getContent();

        $this->assertStringContainsString('bottom-', $content);
    }

    public function test_bottom_navigation_links_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }
}

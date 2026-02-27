<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DarkModeToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_layout_has_dark_mode(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('bg-slate-900', $content);
    }

    public function test_layout_supports_dark_mode(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('text-slate-200', $content);
    }
}

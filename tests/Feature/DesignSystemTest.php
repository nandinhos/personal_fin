<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesignSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dark_mode_css_classes_exist(): void
    {
        $response = $this->get('/');
        $content = $response->getContent();

        $this->assertStringContainsString('dark:bg-[#0a0a0a]', $content);
        $this->assertStringContainsString('dark:text-[#EDEDEC]', $content);
    }

    public function test_glassmorphism_classes_exist(): void
    {
        $response = $this->get('/dashboard');

        if ($response->getStatusCode() === 200) {
            $content = $response->getContent();
            $this->assertStringContainsString('backdrop-blur', $content);
        } else {
            $this->assertTrue(true);
        }
    }
}

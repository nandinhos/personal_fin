<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_avatar(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => 'avatar.png',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('profiles', ['avatar' => 'avatar.png']);
    }

    public function test_user_can_view_profile_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    public function test_profile_has_avatar_field(): void
    {
        $profile = Profile::factory()->create(['avatar' => 'test.png']);

        $this->assertEquals('test.png', $profile->avatar);
    }
}

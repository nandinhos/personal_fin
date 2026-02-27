<?php

namespace Tests\Unit\Factories;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_profile(): void
    {
        $profile = Profile::factory()->create();

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'name' => $profile->name,
        ]);
    }

    public function test_profile_has_user_relationship(): void
    {
        $profile = Profile::factory()->create();

        $this->assertNotNull($profile->user_id);
        $this->assertInstanceOf(\App\Models\User::class, $profile->user);
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Goal;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalTest extends TestCase
{
    use RefreshDatabase;

    public function test_goal_can_be_created(): void
    {
        $profile = Profile::factory()->create();

        $goal = Goal::create([
            'profile_id' => $profile->id,
            'name' => 'Viagem para Europa',
            'target_amount' => 15000.00,
            'current_amount' => 5000.00,
            'deadline' => now()->addYear(),
        ]);

        $this->assertDatabaseHas('goals', [
            'name' => 'Viagem para Europa',
            'target_amount' => 15000.00,
        ]);
    }

    public function test_goal_belongs_to_profile(): void
    {
        $profile = Profile::factory()->create();

        $goal = Goal::create([
            'profile_id' => $profile->id,
            'name' => 'Carro Novo',
            'target_amount' => 80000.00,
            'deadline' => now()->addYears(2),
        ]);

        $this->assertInstanceOf(Profile::class, $goal->profile);
    }

    public function test_goal_progress_percentage(): void
    {
        $profile = Profile::factory()->create();

        $goal = Goal::create([
            'profile_id' => $profile->id,
            'name' => 'Casa Própria',
            'target_amount' => 10000.00,
            'current_amount' => 2500.00,
            'deadline' => now()->addYear(),
        ]);

        $this->assertEquals(25, $goal->progress_percentage);
    }
}

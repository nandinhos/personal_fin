<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Limit;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_limit_can_be_created(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $limit = Limit::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'amount' => 1000.00,
            'period' => 'monthly',
        ]);

        $this->assertDatabaseHas('limits', [
            'amount' => 1000.00,
            'period' => 'monthly',
        ]);
    }

    public function test_limit_belongs_to_profile(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $limit = Limit::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);

        $this->assertInstanceOf(Profile::class, $limit->profile);
    }

    public function test_limit_belongs_to_category(): void
    {
        $profile = Profile::factory()->create();
        $category = Category::factory()->create(['profile_id' => $profile->id, 'type' => 'expense']);

        $limit = Limit::create([
            'profile_id' => $profile->id,
            'category_id' => $category->id,
            'amount' => 800.00,
            'period' => 'monthly',
        ]);

        $this->assertInstanceOf(Category::class, $limit->category);
    }
}

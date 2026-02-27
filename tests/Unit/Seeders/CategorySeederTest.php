<?php

namespace Tests\Unit\Seeders;

use App\Models\Category;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_income_categories(): void
    {
        $profile = Profile::factory()->create();

        $this->seed(\Database\Seeders\CategorySeeder::class);

        $incomeCategories = Category::where('profile_id', $profile->id)
            ->where('type', 'income')
            ->get();

        $this->assertGreaterThan(0, $incomeCategories->count());
        $this->assertTrue($incomeCategories->contains('name', 'Salário'));
    }

    public function test_creates_expense_categories(): void
    {
        $profile = Profile::factory()->create();

        $this->seed(\Database\Seeders\CategorySeeder::class);

        $expenseCategories = Category::where('profile_id', $profile->id)
            ->where('type', 'expense')
            ->get();

        $this->assertGreaterThan(0, $expenseCategories->count());
        $this->assertTrue($expenseCategories->contains('name', 'Alimentação'));
    }

    public function test_categories_have_required_fields(): void
    {
        $profile = Profile::factory()->create();

        $this->seed(\Database\Seeders\CategorySeeder::class);

        $category = Category::where('profile_id', $profile->id)->first();

        $this->assertNotNull($category->name);
        $this->assertNotNull($category->type);
        $this->assertNotNull($category->icon);
        $this->assertNotNull($category->color);
        $this->assertTrue($category->is_default);
    }

    public function test_creates_categories_for_given_profile(): void
    {
        $profile = Profile::factory()->create();

        $this->seed(\Database\Seeders\CategorySeeder::class);

        $categories = Category::where('profile_id', $profile->id)->get();

        $this->assertGreaterThan(0, $categories->count());
        $this->assertEquals($profile->id, $categories->first()->profile_id);
    }
}

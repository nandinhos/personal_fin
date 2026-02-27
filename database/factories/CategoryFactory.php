<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'icon' => $this->faker->randomElement(['briefcase', 'utensils', 'car', 'house']),
            'color' => $this->faker->hexColor(),
            'is_default' => false,
        ];
    }
}

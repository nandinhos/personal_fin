<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'category_id' => Category::factory(),
            'account_id' => null,
            'card_id' => null,
            'type' => $this->faker->randomElement(['income', 'expense']),
            'amount' => $this->faker->randomFloat(2, 10, 5000),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'is_recurring' => false,
            'recurring_frequency' => null,
        ];
    }
}

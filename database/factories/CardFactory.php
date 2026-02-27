<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'name' => $this->faker->company().' Card',
            'type' => $this->faker->randomElement(['credit', 'debit']),
            'last_four_digits' => $this->faker->numerify('####'),
            'limit' => $this->faker->randomFloat(2, 1000, 20000),
            'current_balance' => 0,
            'closing_day' => $this->faker->randomElement([5, 10, 15, 20, 25]),
            'due_day' => $this->faker->randomElement([5, 10, 15, 20, 25]),
            'color' => $this->faker->hexColor(),
            'brand' => $this->faker->randomElement(['Visa', 'Mastercard', 'Elo']),
            'is_active' => true,
        ];
    }
}

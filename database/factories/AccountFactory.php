<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['checking', 'savings', 'investment']),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'color' => $this->faker->hexColor(),
            'is_active' => true,
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $profile = Profile::first();

        if (! $profile) {
            return;
        }

        $categories = [
            'income' => [
                ['name' => 'Salário', 'icon' => 'briefcase', 'color' => '#22c55e'],
                ['name' => 'Freelance', 'icon' => 'laptop', 'color' => '#14b8a6'],
                ['name' => 'Investimentos', 'icon' => 'chart-line', 'color' => '#3b82f6'],
            ],
            'expense' => [
                ['name' => 'Alimentação', 'icon' => 'utensils', 'color' => '#f59e0b'],
                ['name' => 'Transporte', 'icon' => 'car', 'color' => '#ef4444'],
                ['name' => 'Moradia', 'icon' => 'house', 'color' => '#8b5cf6'],
            ],
        ];

        foreach ($categories as $type => $items) {
            foreach ($items as $item) {
                Category::create([
                    'profile_id' => $profile->id,
                    'name' => $item['name'],
                    'type' => $type,
                    'icon' => $item['icon'],
                    'color' => $item['color'],
                    'is_default' => true,
                ]);
            }
        }
    }
}

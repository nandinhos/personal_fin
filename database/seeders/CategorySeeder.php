<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $profiles = Profile::all();

        if ($profiles->isEmpty()) {
            $this->command->warn('Nenhum perfil encontrado. Execute o seeder de usuários primeiro.');

            return;
        }

        $categories = $this->getCategoriesData();

        foreach ($profiles as $profile) {
            foreach ($categories as $type => $categoryItems) {
                foreach ($categoryItems as $categoryData) {
                    $category = Category::create([
                        'profile_id' => $profile->id,
                        'name' => $categoryData['name'],
                        'type' => $type,
                        'icon' => $categoryData['icon'] ?? null,
                        'color' => $categoryData['color'] ?? null,
                        'is_default' => true,
                    ]);

                    if (isset($categoryData['subcategories'])) {
                        foreach ($categoryData['subcategories'] as $subData) {
                            Subcategory::create([
                                'category_id' => $category->id,
                                'name' => $subData['name'],
                                'icon' => $subData['icon'] ?? null,
                                'color' => $subData['color'] ?? null,
                                'is_default' => true,
                            ]);
                        }
                    }

                    $this->command->info("Categoria criada para perfil {$profile->id}: {$category->name}");
                }
            }
        }

        $this->command->info('Categorias e subcategorias criadas com sucesso!');
    }

    private function getCategoriesData(): array
    {
        return [
            'income' => [
                [
                    'name' => 'Salário',
                    'icon' => 'briefcase',
                    'color' => '#22c55e',
                    'subcategories' => [
                        ['name' => 'Salário Mensal', 'icon' => 'money-bill', 'color' => '#22c55e'],
                        ['name' => 'Comissão', 'icon' => 'percent', 'color' => '#16a34a'],
                        ['name' => 'Bônus', 'icon' => 'gift', 'color' => '#15803d'],
                        ['name' => 'PLR', 'icon' => 'chart-line', 'color' => '#166534'],
                    ],
                ],
                [
                    'name' => 'Freelance',
                    'icon' => 'laptop',
                    'color' => '#14b8a6',
                    'subcategories' => [
                        ['name' => 'Desenvolvimento Web', 'icon' => 'code', 'color' => '#14b8a6'],
                        ['name' => 'Design', 'icon' => 'palette', 'color' => '#0d9488'],
                        ['name' => 'Consultoria', 'icon' => 'user-tie', 'color' => '#0f766e'],
                        ['name' => 'Redação', 'icon' => 'pen', 'color' => '#115e59'],
                    ],
                ],
                [
                    'name' => 'Investimentos',
                    'icon' => 'chart-line',
                    'color' => '#3b82f6',
                    'subcategories' => [
                        ['name' => 'Rendimentos', 'icon' => 'trending-up', 'color' => '#3b82f6'],
                        ['name' => 'Dividendos', 'icon' => 'coins', 'color' => '#2563eb'],
                        ['name' => 'Juros', 'icon' => 'percent', 'color' => '#1d4ed8'],
                        ['name' => 'Aluguel', 'icon' => 'home', 'color' => '#1e40af'],
                    ],
                ],
                [
                    'name' => 'Outros Rendimentos',
                    'icon' => 'plus-circle',
                    'color' => '#8b5cf6',
                    'subcategories' => [
                        ['name' => 'Vendas', 'icon' => 'shopping-cart', 'color' => '#8b5cf6'],
                        ['name' => 'Herança', 'icon' => 'inherit', 'color' => '#7c3aed'],
                        ['name' => 'Presente', 'icon' => 'gift', 'color' => '#6d28d9'],
                        ['name' => 'Reembolso', 'icon' => 'reply', 'color' => '#5b21b6'],
                    ],
                ],
            ],
            'expense' => [
                [
                    'name' => 'Alimentação',
                    'icon' => 'utensils',
                    'color' => '#f59e0b',
                    'subcategories' => [
                        ['name' => 'Supermercado', 'icon' => 'shopping-basket', 'color' => '#f59e0b'],
                        ['name' => 'Restaurante', 'icon' => 'utensils', 'color' => '#d97706'],
                        ['name' => 'Delivery', 'icon' => 'motorcycle', 'color' => '#b45309'],
                        ['name' => 'Lanche', 'icon' => 'burger', 'color' => '#92400e'],
                    ],
                ],
                [
                    'name' => 'Transporte',
                    'icon' => 'car',
                    'color' => '#ef4444',
                    'subcategories' => [
                        ['name' => 'Combustível', 'icon' => 'gas-pump', 'color' => '#ef4444'],
                        ['name' => 'Uber/Taxi', 'icon' => 'taxi', 'color' => '#dc2626'],
                        ['name' => 'Ônibus', 'icon' => 'bus', 'color' => '#b91c1c'],
                        ['name' => 'Estacionamento', 'icon' => 'parking', 'color' => '#991b1b'],
                        ['name' => 'Metrô', 'icon' => 'subway', 'color' => '#7f1d1d'],
                    ],
                ],
                [
                    'name' => 'Moradia',
                    'icon' => 'home',
                    'color' => '#8b5cf6',
                    'subcategories' => [
                        ['name' => 'Aluguel', 'icon' => 'building', 'color' => '#8b5cf6'],
                        ['name' => 'Condomínio', 'icon' => 'building', 'color' => '#7c3aed'],
                        ['name' => 'Conta de Luz', 'icon' => 'bolt', 'color' => '#6d28d9'],
                        ['name' => 'Conta de Água', 'icon' => 'droplet', 'color' => '#5b21b6'],
                        ['name' => 'Internet', 'icon' => 'wifi', 'color' => '#4c1d95'],
                        ['name' => 'Telefone', 'icon' => 'phone', 'color' => '#3b0764'],
                    ],
                ],
                [
                    'name' => 'Lazer',
                    'icon' => 'gamepad',
                    'color' => '#ec4899',
                    'subcategories' => [
                        ['name' => 'Netflix', 'icon' => 'play', 'color' => '#ec4899'],
                        ['name' => 'Spotify', 'icon' => 'music', 'color' => '#db2777'],
                        ['name' => 'Cinema', 'icon' => 'film', 'color' => '#be185d'],
                        ['name' => 'Viagem', 'icon' => 'plane', 'color' => '#9d174d'],
                        ['name' => 'Academia', 'icon' => 'dumbbell', 'color' => '#831843'],
                    ],
                ],
                [
                    'name' => 'Saúde',
                    'icon' => 'heartbeat',
                    'color' => '#f43f5e',
                    'subcategories' => [
                        ['name' => 'Plano de Saúde', 'icon' => 'shield-heart', 'color' => '#f43f5e'],
                        ['name' => 'Remédios', 'icon' => 'pills', 'color' => '#e11d48'],
                        ['name' => 'Médico', 'icon' => 'user-md', 'color' => '#be123c'],
                        ['name' => 'Dentista', 'icon' => 'tooth', 'color' => '#9f1239'],
                    ],
                ],
                [
                    'name' => 'Educação',
                    'icon' => 'graduation-cap',
                    'color' => '#06b6d4',
                    'subcategories' => [
                        ['name' => 'Faculdade', 'icon' => 'university', 'color' => '#06b6d4'],
                        ['name' => 'Cursos', 'icon' => 'book-open', 'color' => '#0891b2'],
                        ['name' => 'Livros', 'icon' => 'book', 'color' => '#0e7490'],
                        ['name' => 'Escola', 'icon' => 'school', 'color' => '#155e75'],
                    ],
                ],
                [
                    'name' => 'Vestuário',
                    'icon' => 'tshirt',
                    'color' => '#84cc16',
                    'subcategories' => [
                        ['name' => 'Roupas', 'icon' => 'shirt', 'color' => '#84cc16'],
                        ['name' => 'Calçados', 'icon' => 'shoe-prints', 'color' => '#65a30d'],
                        ['name' => 'Acessórios', 'icon' => 'watch', 'color' => '#4d7c0f'],
                    ],
                ],
                [
                    'name' => 'Pets',
                    'icon' => 'paw',
                    'color' => '#f97316',
                    'subcategories' => [
                        ['name' => 'Ração', 'icon' => 'bone', 'color' => '#f97316'],
                        ['name' => 'Veterinário', 'icon' => 'stethoscope', 'color' => '#ea580c'],
                        ['name' => 'Banho/Tosa', 'icon' => 'scissors', 'color' => '#c2410c'],
                    ],
                ],
                [
                    'name' => 'Assinaturas',
                    'icon' => 'repeat',
                    'color' => '#6366f1',
                    'subcategories' => [
                        ['name' => 'Streaming', 'icon' => 'tv', 'color' => '#6366f1'],
                        ['name' => 'Software', 'icon' => 'app', 'color' => '#4f46e5'],
                        ['name' => 'Mensalidades', 'icon' => 'calendar', 'color' => '#4338ca'],
                    ],
                ],
                [
                    'name' => 'Outros',
                    'icon' => 'ellipsis-h',
                    'color' => '#64748b',
                    'subcategories' => [
                        ['name' => 'Imprevistos', 'icon' => 'exclamation-triangle', 'color' => '#64748b'],
                        ['name' => 'Doações', 'icon' => 'hand-holding-heart', 'color' => '#475569'],
                        ['name' => 'Emprestimos', 'icon' => 'handshake', 'color' => '#334155'],
                    ],
                ],
            ],
        ];
    }
}

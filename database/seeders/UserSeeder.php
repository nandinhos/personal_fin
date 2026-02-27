<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@fin.com',
                'password' => 'password',
                'is_admin' => true,
                'profile'  => 'Principal',
            ],
            [
                'name'     => 'Usuário',
                'email'    => 'user@fin.com',
                'password' => 'password',
                'is_admin' => false,
                'profile'  => 'Principal',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'is_admin' => $data['is_admin'],
                    'password' => bcrypt($data['password']),
                ]
            );

            // Garante is_admin atualizado em re-seeds
            $user->update(['is_admin' => $data['is_admin']]);

            if ($user->profiles()->doesntExist()) {
                $user->profiles()->create([
                    'name'       => $data['profile'],
                    'is_default' => true,
                ]);
            }

            $label = $data['is_admin'] ? '[admin]' : '[user]';
            $this->command->info("Usuário pronto {$label}: {$user->email}");
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем главного админа
        User::firstOrCreate(
            ['email' => 'admin@getgrant.com'],
            [
                'name' => 'Главный администратор',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'profile_type' => 'student', // для совместимости с enum
                'email_verified_at' => now(),
            ]
        );

        // Создаем несколько менеджеров
        User::firstOrCreate(
            ['email' => 'manager1@getgrant.com'],
            [
                'name' => 'Менеджер 1',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
                'profile_type' => 'student',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager2@getgrant.com'],
            [
                'name' => 'Менеджер 2',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
                'profile_type' => 'student',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Администраторы и менеджеры созданы!');
        $this->command->info('Админ: admin@getgrant.com / admin123');
        $this->command->info('Менеджеры: manager1@getgrant.com / manager123');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationStep;
use App\Models\Course;
use App\Models\Document;
use App\Models\Lead;
use App\Models\Lesson;
use App\Models\Manager;
use App\Models\Message;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Создаем админа (если не существует) ---
        User::firstOrCreate(
            ['email' => 'admin@getgrant.com'],
            [
                'name' => 'Администратор',
                'password' => \Hash::make('admin123'),
                'role' => 'admin',
                'profile_type' => 'student', // для совместимости
                'email_verified_at' => now(),
            ]
        );

        // --- Создаем менеджеров ---
        Manager::factory(3)->create();

        // --- Создаем пользователей (студенты + родители) ---
        $users = User::factory(10)->create();

        // --- Назначаем менеджеров случайным пользователям ---
        $users->each(function ($user) {
            $user->manager_id = Manager::inRandomOrder()->first()->id;
            $user->save();
        });

        // --- Создаем лиды ---
        foreach ($users as $user) {
            Lead::factory(rand(1, 3))->create([
                'user_id' => $user->id,
                'manager_id' => $user->manager_id,
            ]);
        }

        // --- Создаем курсы ---
        $courses = Course::factory(5)->create();

        // --- Создаем уроки ---
        foreach ($courses as $course) {
            Lesson::factory(5)->create([
                'course_id' => $course->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // --- Создаем документы ---
        $documents = Document::factory(5)->create();

        // --- Создаем пользователей документы ---
        foreach ($users as $user) {
            foreach ($documents as $doc) {
                UserDocument::factory(1)->create([
                    'user_id' => $user->id,
                    'application_id' => Application::factory()->create([
                        'user_id' => $user->id,
                    ])->id,
                    'type' => $doc->type,
                    'file_path' => $doc->file_path,
                ]);
            }
        }

        // --- Создаем приложения и шаги ---
        foreach ($users as $user) {
            $applications = Application::factory(rand(1, 2))->create([
                'user_id' => $user->id,
            ]);

            foreach ($applications as $app) {
                ApplicationStep::factory(rand(2, 4))->create([
                    'application_id' => $app->id,
                ]);
            }
        }

        // --- Создаем сообщения ---
        foreach ($users as $user) {
            Message::factory(rand(1, 5))->create([
                'sender_id' => $user->id,
                'receiver_id' => $users->where('id', '!=', $user->id)->random()->id,
                'application_id' => Application::inRandomOrder()->first()->id,
            ]);
        }
    }
}

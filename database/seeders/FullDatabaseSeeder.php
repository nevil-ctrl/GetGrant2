<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Category;
use App\Models\Country;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Models\Program;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FullDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем админа и менеджеров
        $admin = User::firstOrCreate(
            ['email' => 'admin@getgrant.com'],
            [
                'name' => 'Главный администратор',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'profile_type' => 'student',
                'email_verified_at' => now(),
            ]
        );

        $managers = [];
        for ($i = 1; $i <= 3; $i++) {
            $managers[] = User::firstOrCreate(
                ['email' => "manager{$i}@getgrant.com"],
                [
                    'name' => "Менеджер {$i}",
                    'password' => Hash::make('manager123'),
                    'role' => 'manager',
                    'profile_type' => 'student',
                    'email_verified_at' => now(),
                ]
            );
        }

        // 2. Создаем 20 студентов
        $students = [];
        for ($i = 1; $i <= 20; $i++) {
            $students[] = User::create([
                'name' => "Студент {$i}",
                'email' => "student{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'student',
                'profile_type' => 'student',
                'manager_id' => $managers[array_rand($managers)]->id,
                'email_verified_at' => now(),
            ]);
        }

        // 3. Создаем 10 стран (если их еще нет)
        $this->call(CountriesSeeder::class);
        $countries = Country::where('is_active', true)->get();

        // 4. Создаем 20 университетов
        $universities = [];
        foreach ($countries->random(min(10, $countries->count())) as $country) {
            for ($i = 0; $i < 2; $i++) {
                $universities[] = University::create([
                    'country_id' => $country->id,
                    'name' => "Университет " . $country->name . " " . ($i + 1),
                    'description' => "Описание университета в " . $country->name,
                    'level' => ['bachelor', 'master', 'all'][array_rand(['bachelor', 'master', 'all'])],
                    'cost_min' => rand(5000, 15000),
                    'cost_max' => rand(20000, 50000),
                    'is_active' => true,
                ]);
            }
        }

        // 5. Создаем 50 программ
        $programs = [];
        foreach ($universities as $university) {
            for ($i = 0; $i < 2; $i++) {
                $programs[] = Program::create([
                    'university_id' => $university->id,
                    'name' => "Программа " . ($i + 1) . " в " . $university->name,
                    'description' => "Описание программы",
                    'field_of_study' => ['IT', 'Business', 'Engineering', 'Medicine', 'Arts'][array_rand(['IT', 'Business', 'Engineering', 'Medicine', 'Arts'])],
                    'is_top' => rand(0, 1),
                    'is_active' => true,
                ]);
            }
        }

        // 6. Создаем 5 категорий (используем firstOrCreate чтобы избежать дубликатов)
        $categories = [];
        $categoryNames = ['Программирование', 'Математика', 'Английский язык', 'Бизнес', 'Дизайн'];
        foreach ($categoryNames as $name) {
            $categories[] = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => "Описание категории {$name}",
                    'is_active' => true,
                ]
            );
        }

        // 7. Создаем курсы
        $courses = \App\Models\Course::factory(5)->create(['is_active' => true]);

        // 8. Создаем 10 уроков
        $lessons = [];
        foreach ($categories as $category) {
            for ($i = 0; $i < 2; $i++) {
                $lessons[] = Lesson::create([
                    'course_id' => $courses->random()->id,
                    'user_id' => $managers[array_rand($managers)]->id,
                    'title' => "Урок " . ($i + 1) . " - " . $category->name,
                    'description' => "Описание урока в категории {$category->name}",
                    'language' => ['ru', 'en'][array_rand(['ru', 'en'])],
                    'category_id' => $category->id,
                    'order' => $i,
                    'is_published' => true,
                ]);
            }
        }

        // 9. Создаем 5 зданий
        $buildings = [];
        $buildingNames = ['Главный корпус', 'Корпус А', 'Корпус Б', 'Библиотека', 'Спортивный комплекс'];
        foreach ($buildingNames as $name) {
            $buildings[] = Building::create([
                'lesson_id' => $lessons[array_rand($lessons)]->id ?? null,
                'name' => $name,
                'location' => "Адрес " . $name,
                'image' => null,
            ]);
        }

        // 10. Создаем 20 заданий
        $assignments = [];
        foreach ($lessons as $lesson) {
            for ($i = 0; $i < 2; $i++) {
                $assignments[] = Assignment::create([
                    'lesson_id' => $lesson->id,
                    'building_id' => $buildings[array_rand($buildings)]->id ?? null,
                    'title' => "Задание " . ($i + 1) . " к уроку " . $lesson->title,
                    'description' => "Описание задания",
                    'due_date' => now()->addDays(rand(7, 30)),
                    'status' => ['pending', 'submitted', 'approved'][array_rand(['pending', 'submitted', 'approved'])],
                ]);
            }
        }

        // 11. Создаем enrollments (привязки студентов к урокам)
        foreach ($students as $student) {
            foreach ($lessons->random(rand(3, 7)) as $lesson) {
                Enrollment::create([
                    'user_id' => $student->id,
                    'lesson_id' => $lesson->id,
                    'status' => ['enrolled', 'started', 'finished', 'inactive'][array_rand(['enrolled', 'started', 'finished', 'inactive'])],
                ]);
            }
        }

        $this->command->info('✅ Создано:');
        $this->command->info("   - 1 админ, 3 менеджера");
        $this->command->info("   - " . count($students) . " студентов");
        $this->command->info("   - " . count($countries) . " стран");
        $this->command->info("   - " . count($universities) . " университетов");
        $this->command->info("   - " . count($programs) . " программ");
        $this->command->info("   - " . count($categories) . " категорий");
        $this->command->info("   - " . count($lessons) . " уроков");
        $this->command->info("   - " . count($buildings) . " зданий");
        $this->command->info("   - " . count($assignments) . " заданий");
        $this->command->info("   - " . Enrollment::count() . " записей о зачислении");
    }
}

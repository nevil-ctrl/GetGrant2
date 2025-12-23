<?php

namespace Database\Factories;

use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = \App\Models\Program::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'university_id' => University::factory(),
            'description' => $this->faker->paragraph(),
            'field_of_study' => $this->faker->randomElement(['Computer Science', 'Business', 'Engineering', 'Arts']),
            'is_top' => $this->faker->boolean(30),
            'career_info' => json_encode([
                'average_salary' => $this->faker->numberBetween(30000, 120000),
                'job_growth' => $this->faker->numberBetween(5, 20).'%',
            ]),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}

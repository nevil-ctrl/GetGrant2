<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'university_id' => University::factory(),
            'program_id' => Program::factory(),
            'status' => $this->faker->randomElement(['consultation', 'documents', 'submission', 'offer', 'visa', 'departure']),
            'timeline' => [
                'consultation' => now()->addDays(1)->toDateString(),
                'document' => now()->addDays(3)->toDateString(),
            ],
            'notes' => $this->faker->sentence(),

        ];
    }
}

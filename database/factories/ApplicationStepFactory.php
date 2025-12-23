<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationStepFactory extends Factory
{
    protected $model = ApplicationStep::class;

    public function definition()
    {
        return [
            'application_id' => Application::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'completed_at' => null,
        ];
    }
}

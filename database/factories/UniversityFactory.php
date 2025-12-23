<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    protected $model = \App\Models\University::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' University',
            'country_id' => Country::factory(), // создаст новую страну автоматически
            'description' => $this->faker->paragraph(),
            'logo' => 'https://picsum.photos/seed/logo'.$this->faker->unique()->numberBetween(1, 1000).'/200/200',
            'website' => $this->faker->url(),
            'cost_min' => $this->faker->numberBetween(5000, 15000),
            'cost_max' => $this->faker->numberBetween(15001, 40000),
            'requirements' => json_encode([
                'ielts' => $this->faker->randomFloat(1, 5, 8),
                'gpa' => $this->faker->randomFloat(2, 2.0, 4.0),
            ]),
            'deadlines' => json_encode([
                'fall' => $this->faker->date(),
                'spring' => $this->faker->date(),
            ]),
            'level' => $this->faker->randomElement(['bachelor', 'master', 'phd', 'all']),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}

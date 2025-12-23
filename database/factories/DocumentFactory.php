<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['license', 'certificate', 'other']),
            'file_path' => 'documents/'.$this->faker->uuid().'.pdf',
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}

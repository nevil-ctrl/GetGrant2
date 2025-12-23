<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDocumentFactory extends Factory
{
    protected $model = UserDocument::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'application_id' => Application::factory(),
            'type' => $this->faker->randomElement(['license', 'certificate', 'other']),
            'file_path' => 'user_documents/'.$this->faker->uuid().'.pdf',
            'status' => $this->faker->randomElement(['waiting', 'approved', 'rejected']),
            'comment' => $this->faker->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'application_id' => Application::factory(),
            'message' => $this->faker->paragraph(),
            'read_at' => null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'scheduled_at' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'duration' => $this->faker->numberBetween(30, 120),
            'meeting_link' => $this->faker->url(),
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']),
        ];
    }
}

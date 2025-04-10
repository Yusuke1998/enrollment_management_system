<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->numberBetween(1, 10),
            'course_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
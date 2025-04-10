<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date('Y-m-d', '2010-01-01'),
            'father_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
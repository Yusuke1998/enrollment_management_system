<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'cost' => $this->faker->randomFloat(2, 50, 300),
            'duration' => $this->faker->numberBetween(10, 100),
            'modality' => $this->faker->randomElement(['presencial', 'virtual']),
            'academy_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
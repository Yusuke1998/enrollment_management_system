<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'sent_date' => $this->faker->date(),
            'communicable_id' => $this->faker->numberBetween(1, 10),
            'communicable_type' => $this->faker->randomElement(['App\Models\Father', 'App\Models\Course']),
        ];
    }
}
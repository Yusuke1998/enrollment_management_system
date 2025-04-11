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
            'criteria_course_id' => \App\Models\Course::factory()->create()->id, // Assuming you have a Course factory
            'criteria_min_age' => $this->faker->numberBetween(18, 65),
            'criteria_max_age' => $this->faker->numberBetween(18, 65),
        ];
    }
}
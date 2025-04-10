<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enrollment;

class PayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'method' => $this->faker->randomElement(['efectivo', 'transferencia']),
            'amount' => $this->faker->randomFloat(2, 50, 300),
            'payment_date' => $this->faker->date(),
            'enrollment_id' => Enrollment::inRandomOrder()->first()->id ?? Enrollment::factory(),
        ];
    }
}
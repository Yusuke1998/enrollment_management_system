<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pay;

class PaySeeder extends Seeder
{
    public function run(): void
    {
        Pay::factory()->count(10)->create();
    }
}
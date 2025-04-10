<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academy;

class AcademySeeder extends Seeder
{
    public function run(): void
    {
        Academy::factory()->count(10)->create();
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Father;

class FatherSeeder extends Seeder
{
    public function run(): void
    {
        Father::factory()->count(10)->create();
    }
}
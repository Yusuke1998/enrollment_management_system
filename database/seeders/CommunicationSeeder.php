<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Communication;

class CommunicationSeeder extends Seeder
{
    public function run(): void
    {
        Communication::factory()->count(2)->create();
    }
}
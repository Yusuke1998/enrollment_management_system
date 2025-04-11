<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Father;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create user admin, el admin es el usuario de id 1
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        $fatherUser = User::factory()->create([
            'name' => 'father',
            'email' => 'father@father.com',
            'password' => bcrypt('father'),
        ]);
        Father::factory()->create([
            'user_id' => $fatherUser->id,
        ]);
        $this->call([
            AcademySeeder::class,
            CommunicationSeeder::class,
            CourseSeeder::class,
            FatherSeeder::class,
            StudentSeeder::class,
            EnrollmentSeeder::class,
            PaySeeder::class,
        ]);
    }
}
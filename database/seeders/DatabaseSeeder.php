<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        // Ejecutar seeders en orden de dependencias
        $this->call([
            UserSeeder::class,
            // TrackSeeder::class,
            // CourseSeeder::class,
            // LessonSeeder::class,
            // LessonItemSeeder::class,
            // QuestionSeeder::class,
            // QuestionOptionSeeder::class,
            // EnrollmentSeeder::class,
        ]);
    }
}

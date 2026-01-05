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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ejecutar seeders en orden de dependencias
        $this->call([
            TrackSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            LessonItemSeeder::class,
            QuestionSeeder::class,
            QuestionOptionSeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}

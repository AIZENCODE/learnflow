<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $tracks = Track::all();
        $courses = Course::all();

        if ($user === null) {
            $this->command->warn('No hay usuarios disponibles. Ejecuta DatabaseSeeder primero.');
            return;
        }

        // Inscripción en una ruta completa
        if ($tracks->isNotEmpty()) {
            $firstTrack = $tracks->first();
            
            Enrollment::create([
                'user_id' => $user->id,
                'track_id' => $firstTrack->id,
                'course_id' => null,
                'status' => 'active',
                'enrolled_at' => now()->subDays(5),
                'expires_at' => null,
            ]);
        }

        // Inscripciones en cursos individuales
        if ($courses->isNotEmpty()) {
            $firstCourse = $courses->first();
            
            Enrollment::create([
                'user_id' => $user->id,
                'track_id' => null,
                'course_id' => $firstCourse->id,
                'status' => 'active',
                'enrolled_at' => now()->subDays(3),
                'expires_at' => null,
            ]);

            // Curso completado
            if ($courses->count() > 1) {
                $secondCourse = $courses->skip(1)->first();
                
                Enrollment::create([
                    'user_id' => $user->id,
                    'track_id' => null,
                    'course_id' => $secondCourse->id,
                    'status' => 'completed',
                    'enrolled_at' => now()->subDays(30),
                    'completed_at' => now()->subDays(15),
                    'expires_at' => null,
                ]);
            }

            // Curso pausado
            if ($courses->count() > 2) {
                $thirdCourse = $courses->skip(2)->first();
                
                Enrollment::create([
                    'user_id' => $user->id,
                    'track_id' => null,
                    'course_id' => $thirdCourse->id,
                    'status' => 'paused',
                    'enrolled_at' => now()->subDays(10),
                    'expires_at' => null,
                ]);
            }
        }
    }
}

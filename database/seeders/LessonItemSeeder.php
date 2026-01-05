<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $lessons = Lesson::all();

        if ($lessons->isEmpty()) {
            $this->command->warn('No hay lecciones disponibles. Ejecuta LessonSeeder primero.');
            return;
        }

        foreach ($lessons as $lesson) {
            // Primer item: Video de introducción
            LessonItem::create([
                'title' => 'Video: Introducción',
                'description' => 'Video introductorio a este módulo',
                'order' => 1,
                'content_type' => 'video',
                'completion_type' => 'automatic',
                'video_url' => 'https://example.com/videos/intro.mp4',
                'video_duration' => 600,
                'is_preview' => true,
                'is_published' => true,
                'requires_completion' => true,
                'xp_points' => 10,
                'lesson_id' => $lesson->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Segundo item: Artículo
            LessonItem::create([
                'title' => 'Artículo: Conceptos Fundamentales',
                'description' => 'Artículo con los conceptos fundamentales del tema',
                'order' => 2,
                'content_type' => 'article',
                'completion_type' => 'automatic',
                'content' => '<h1>Conceptos Fundamentales</h1><p>Este es el contenido del artículo...</p>',
                'is_preview' => false,
                'is_published' => true,
                'requires_completion' => true,
                'xp_points' => 15,
                'lesson_id' => $lesson->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Tercer item: Quiz (solo para algunas lecciones)
            if ($lesson->order % 2 == 0) {
                LessonItem::create([
                    'title' => 'Quiz: Evaluación de Conocimientos',
                    'description' => 'Pon a prueba lo que has aprendido',
                    'order' => 3,
                    'content_type' => 'quiz',
                    'completion_type' => 'quiz',
                    'content' => '<p>Completa este quiz para validar tus conocimientos</p>',
                    'is_preview' => false,
                    'is_published' => true,
                    'requires_completion' => true,
                    'xp_points' => 20,
                    'lesson_id' => $lesson->id,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
            }

            // Cuarto item: Video avanzado
            LessonItem::create([
                'title' => 'Video: Conceptos Avanzados',
                'description' => 'Video con conceptos más avanzados',
                'order' => 4,
                'content_type' => 'video',
                'completion_type' => 'automatic',
                'video_url' => 'https://example.com/videos/advanced.mp4',
                'video_duration' => 900,
                'is_preview' => false,
                'is_published' => true,
                'requires_completion' => true,
                'xp_points' => 25,
                'lesson_id' => $lesson->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }
    }
}

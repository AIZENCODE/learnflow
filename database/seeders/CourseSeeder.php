<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $tracks = Track::all();

        if ($tracks->isEmpty()) {
            $this->command->warn('No hay tracks disponibles. Ejecuta TrackSeeder primero.');
            return;
        }

        // Cursos para Desarrollo Web Full Stack
        $webTrack = $tracks->first();

        Course::create([
            'title' => 'Fundamentos de HTML y CSS',
            'slug' => Str::slug('Fundamentos de HTML y CSS'),
            'description' => 'Aprende los fundamentos de HTML y CSS para crear páginas web estáticas.',
            'show_media_type' => 'image',
            'icon_path' => 'courses/html-css-icon.png',
            'image_path' => 'courses/html-css.jpg',
            'short_description' => 'Domina HTML y CSS desde cero',
            'duration_minutes' => 480,
            'price' => 0.00,
            'is_free' => true,
            'is_published' => true,
            'order_in_track' => 1,
            'xp_points' => 100,
            'track_id' => $webTrack->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        Course::create([
            'title' => 'JavaScript Moderno',
            'slug' => Str::slug('JavaScript Moderno'),
            'description' => 'Aprende JavaScript desde cero hasta conceptos avanzados como ES6+, async/await y más.',
            'show_media_type' => 'video',
            'video_path' => 'courses/javascript-intro.mp4',
            'short_description' => 'JavaScript desde cero hasta avanzado',
            'duration_minutes' => 720,
            'price' => 49.99,
            'is_free' => false,
            'is_published' => true,
            'order_in_track' => 2,
            'xp_points' => 200,
            'track_id' => $webTrack->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        Course::create([
            'title' => 'Laravel para Principiantes',
            'slug' => Str::slug('Laravel para Principiantes'),
            'description' => 'Aprende a desarrollar aplicaciones web con Laravel, el framework PHP más popular.',
            'show_media_type' => 'image',
            'image_path' => 'courses/laravel.jpg',
            'short_description' => 'Desarrollo backend con Laravel',
            'duration_minutes' => 900,
            'price' => 79.99,
            'is_free' => false,
            'is_published' => true,
            'order_in_track' => 3,
            'xp_points' => 300,
            'track_id' => $webTrack->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Curso para Marketing Digital
        if ($tracks->count() > 1) {
            $marketingTrack = $tracks->skip(1)->first();

            Course::create([
                'title' => 'SEO Avanzado',
                'slug' => Str::slug('SEO Avanzado'),
                'description' => 'Técnicas avanzadas de optimización para motores de búsqueda.',
                'show_media_type' => 'image',
                'image_path' => 'courses/seo.jpg',
                'short_description' => 'Domina el SEO y aumenta tu tráfico',
                'duration_minutes' => 600,
                'price' => 59.99,
                'is_free' => false,
                'is_published' => true,
                'order_in_track' => 1,
                'xp_points' => 150,
                'track_id' => $marketingTrack->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }
    }
}

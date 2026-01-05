<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->command->warn('No hay cursos disponibles. Ejecuta CourseSeeder primero.');
            return;
        }

        foreach ($courses as $course) {
            // Para el curso de HTML y CSS
            if (str_contains($course->title, 'HTML')) {
                Lesson::create([
                    'title' => 'Introducción a HTML',
                    'slug' => Str::slug('Introducción a HTML'),
                    'description' => 'Aprende los conceptos básicos de HTML y su estructura.',
                    'order' => 1,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 25,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Fundamentos de CSS',
                    'slug' => Str::slug('Fundamentos de CSS'),
                    'description' => 'Domina los estilos CSS para dar vida a tus páginas web.',
                    'order' => 2,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 30,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Layouts y Flexbox',
                    'slug' => Str::slug('Layouts y Flexbox'),
                    'description' => 'Crea layouts modernos usando Flexbox y Grid.',
                    'order' => 3,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 35,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
            }

            // Para el curso de JavaScript
            if (str_contains($course->title, 'JavaScript')) {
                Lesson::create([
                    'title' => 'Variables y Tipos de Datos',
                    'slug' => Str::slug('Variables y Tipos de Datos'),
                    'description' => 'Aprende sobre variables, constantes y tipos de datos en JavaScript.',
                    'order' => 1,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 40,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Funciones y Arrow Functions',
                    'slug' => Str::slug('Funciones y Arrow Functions'),
                    'description' => 'Domina las funciones tradicionales y las arrow functions de ES6.',
                    'order' => 2,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 50,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Async/Await y Promesas',
                    'slug' => Str::slug('Async/Await y Promesas'),
                    'description' => 'Aprende programación asíncrona con promesas y async/await.',
                    'order' => 3,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 60,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
            }

            // Para el curso de Laravel
            if (str_contains($course->title, 'Laravel')) {
                Lesson::create([
                    'title' => 'Instalación y Configuración',
                    'slug' => Str::slug('Instalación y Configuración'),
                    'description' => 'Aprende a instalar y configurar Laravel en tu entorno de desarrollo.',
                    'order' => 1,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 50,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Rutas y Controladores',
                    'slug' => Str::slug('Rutas y Controladores'),
                    'description' => 'Domina el sistema de rutas y controladores de Laravel.',
                    'order' => 2,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 60,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                Lesson::create([
                    'title' => 'Eloquent ORM',
                    'slug' => Str::slug('Eloquent ORM'),
                    'description' => 'Aprende a trabajar con la base de datos usando Eloquent ORM.',
                    'order' => 3,
                    'is_published' => true,
                    'course_id' => $course->id,
                    'xp_points' => 70,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.clients.courses.index', compact('courses'));
    }
    public function show(Course $course)
    {
        // Cargar el curso con sus relaciones
        $course->load([
            'track',
            'lessons' => function ($query) {
                $query->where('is_published', true)
                      ->orderBy('order');
            },
            'lessons.lessonItems' => function ($query) {
                $query->where('is_published', true)
                      ->orderBy('order');
            }
        ]);

        // Calcular duración de cada lección (suma de video_duration de lesson_items en minutos)
        $lessons = $course->lessons->map(function ($lesson) {
            $totalSeconds = $lesson->lessonItems->sum('video_duration') ?? 0;
            $lesson->duration_minutes = (int) ceil($totalSeconds / 60);
            return $lesson;
        });

        // Obtener información de la compañía para el layout
        $company = \App\Models\Company::first();

        return view('admin.clients.courses.show', compact('course', 'lessons', 'company'));
    }
}

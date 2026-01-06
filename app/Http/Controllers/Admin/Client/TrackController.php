<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function show(Track $track)
    {
        // Cargar el track con sus cursos ordenados
        $track->load([
            'courses' => function ($query) {
                $query->where('is_published', true)
                      ->orderBy('order_in_track');
            }
        ]);

        // Calcular estadísticas
        $totalCourses = $track->courses->count();
        $totalDuration = $track->courses->sum('duration_minutes');
        $totalHours = floor($totalDuration / 60);
        $totalMinutes = $totalDuration % 60;

        // Obtener información de la compañía para el layout
        $company = \App\Models\Company::first();

        return view('admin.clients.tracks.show', compact('track', 'totalCourses', 'totalHours', 'totalMinutes', 'company'));
    }
}


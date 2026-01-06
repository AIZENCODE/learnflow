<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class GeneralController extends Controller
{
    public function index()
    {
        $user = FacadesAuth::user();
        $company = \App\Models\Company::first();
        $tracks = Track::withCount('courses')
            ->orderBy('order')
            ->get();

        // Estadísticas generales
        $totalTracks = Track::count();
        $totalCourses = \App\Models\Course::count();
        $publishedCourses = \App\Models\Course::where('is_published', true)->count();
        $totalUsers = \App\Models\User::count();

        return view('admin.clients.general', compact('user', 'tracks', 'totalTracks', 'totalCourses', 'publishedCourses', 'totalUsers', 'company'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::paginate(15);
        return view('admin.tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('admin.tracks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'xp_points' => 'required|numeric|min:0',
            'has_time_limit' => 'boolean',
            'start_date' => 'nullable|date|required_if:has_time_limit,1',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:has_time_limit,1',
            'time_limit_type' => 'nullable|in:from_enrollment,fixed_date,self_paced',
        ]);

        $validated['has_time_limit'] = $request->has('has_time_limit') ? true : false;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Si no tiene tiempo límite, limpiar campos relacionados
        if (!$validated['has_time_limit']) {
            $validated['start_date'] = null;
            $validated['end_date'] = null;
            $validated['time_limit_type'] = 'self_paced';
        }

        $track = Track::create($validated);
        return redirect()->route('tracks.index')->with('success', 'Ruta creada exitosamente.');
    }

    public function show(Track $track)
    {
        return view('admin.tracks.show', compact('track'));
    }

    public function edit(Track $track)
    {
        return view('admin.tracks.edit', compact('track'));
    }

    public function update(Request $request, Track $track)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'xp_points' => 'required|numeric|min:0',
            'has_time_limit' => 'boolean',
            'start_date' => 'nullable|date|required_if:has_time_limit,1',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:has_time_limit,1',
            'time_limit_type' => 'nullable|in:from_enrollment,fixed_date,self_paced',
        ]);

        $validated['has_time_limit'] = $request->has('has_time_limit') ? true : false;
        $validated['updated_by'] = Auth::id();

        // Si no tiene tiempo límite, limpiar campos relacionados
        if (!$validated['has_time_limit']) {
            $validated['start_date'] = null;
            $validated['end_date'] = null;
            $validated['time_limit_type'] = 'self_paced';
        }

        $track->update($validated);
        return redirect()->route('tracks.index')->with('success', 'Ruta actualizada exitosamente.');
    }

    public function destroy(Track $track)
    {
        $track->delete();
        return redirect()->route('tracks.index')->with('success', 'Ruta eliminada exitosamente.');
    }
}

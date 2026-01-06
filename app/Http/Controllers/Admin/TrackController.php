<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video_path' => 'nullable|mimes:mp4,webm,ogg|max:10240',
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

        // Manejar subida de archivos
        $mediaFields = ['image_path', 'background_path', 'icon_path', 'video_path'];
        foreach ($mediaFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $tenant = tenancy()->tenant;
                    if (!$tenant) {
                        throw new \Exception('No hay tenant activo.');
                    }

                    $currentStoragePath = storage_path();
                    $expectedTenantPath = 'tenant' . $tenant->id;

                    if (strpos($currentStoragePath, $expectedTenantPath) === false) {
                        \Log::warning('FilesystemTenancyBootstrapper no modificó storage_path(). Forzando configuración manual.');
                        $tenantStoragePath = base_path('storage/' . $expectedTenantPath . '/app/public');
                        config(['filesystems.disks.public.root' => $tenantStoragePath]);
                        app()->forgetInstance('filesystem.disk.public');
                    }

                    $disk = Storage::disk('public');
                    $file = $request->file($field);
                    $filename = 'track_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                    if (!$disk->exists('tracks')) {
                        $disk->makeDirectory('tracks');
                    }

                    $path = $disk->putFileAs('tracks', $file, $filename);
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage());
                    $validated[$field] = null;
                }
            } else {
                $validated[$field] = null;
            }
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
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video_path' => 'nullable|mimes:mp4,webm,ogg|max:10240',
        ]);

        $validated['has_time_limit'] = $request->has('has_time_limit') ? true : false;
        $validated['updated_by'] = Auth::id();

        // Si no tiene tiempo límite, limpiar campos relacionados
        if (!$validated['has_time_limit']) {
            $validated['start_date'] = null;
            $validated['end_date'] = null;
            $validated['time_limit_type'] = 'self_paced';
        }

        // Manejar subida de archivos
        $mediaFields = ['image_path', 'background_path', 'icon_path', 'video_path'];
        foreach ($mediaFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $tenant = tenancy()->tenant;
                    if (!$tenant) {
                        throw new \Exception('No hay tenant activo.');
                    }

                    $currentStoragePath = storage_path();
                    $expectedTenantPath = 'tenant' . $tenant->id;

                    if (strpos($currentStoragePath, $expectedTenantPath) === false) {
                        \Log::warning('FilesystemTenancyBootstrapper no modificó storage_path(). Forzando configuración manual.');
                        $tenantStoragePath = base_path('storage/' . $expectedTenantPath . '/app/public');
                        config(['filesystems.disks.public.root' => $tenantStoragePath]);
                        app()->forgetInstance('filesystem.disk.public');
                    }

                    $disk = Storage::disk('public');

                    // Eliminar archivo anterior si existe
                    if ($track->$field && $disk->exists($track->$field)) {
                        $disk->delete($track->$field);
                    }

                    $file = $request->file($field);
                    $filename = 'track_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                    if (!$disk->exists('tracks')) {
                        $disk->makeDirectory('tracks');
                    }

                    $path = $disk->putFileAs('tracks', $file, $filename);
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage());
                    $validated[$field] = $track->$field;
                }
            } elseif ($track->$field) {
                // Mantener el archivo existente si no se sube uno nuevo
                $validated[$field] = $track->$field;
            } else {
                $validated[$field] = null;
            }
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

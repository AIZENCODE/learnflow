<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('track')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $tracks = Track::all();
        return view('admin.courses.create', compact('tracks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
            'description' => 'nullable|string',
            'show_media_type' => 'required|in:image,video,none',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'video_path' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'is_external_link' => 'boolean',
            'short_description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_published' => 'boolean',
            'order_in_track' => 'nullable|integer|min:0',
            'xp_points' => 'required|numeric|min:0',
            'track_id' => 'nullable|exists:tracks,id',
        ]);

        // Generar slug automáticamente si no se proporciona
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Manejar subida de archivos
        $mediaFields = ['icon_path', 'image_path', 'video_path'];
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
                    $filename = 'course_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                    if (!$disk->exists('courses')) {
                        $disk->makeDirectory('courses');
                    }

                    $path = $disk->putFileAs('courses', $file, $filename);
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage());
                    $validated[$field] = null;
                }
            } else {
                $validated[$field] = null;
            }
        }

        $validated['is_external_link'] = $request->has('is_external_link') ? true : false;
        $validated['is_free'] = $request->has('is_free') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $course = Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Curso creado exitosamente.');
    }

    public function show(Course $course)
    {
        $course->load('track');
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $tracks = Track::all();
        return view('admin.courses.edit', compact('course', 'tracks'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug,' . $course->id,
            'description' => 'nullable|string',
            'show_media_type' => 'required|in:image,video,none',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'video_path' => 'nullable|mimes:mp4,webm,ogg|max:10240',
            'is_external_link' => 'boolean',
            'short_description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_published' => 'boolean',
            'order_in_track' => 'nullable|integer|min:0',
            'xp_points' => 'required|numeric|min:0',
            'track_id' => 'nullable|exists:tracks,id',
        ]);

        // Generar slug automáticamente si no se proporciona
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Manejar subida de archivos
        $mediaFields = ['icon_path', 'image_path', 'video_path'];
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
                    if ($course->$field && $disk->exists($course->$field)) {
                        $disk->delete($course->$field);
                    }

                    $file = $request->file($field);
                    $filename = 'course_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                    if (!$disk->exists('courses')) {
                        $disk->makeDirectory('courses');
                    }

                    $path = $disk->putFileAs('courses', $file, $filename);
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage());
                    $validated[$field] = $course->$field;
                }
            } elseif ($course->$field) {
                // Mantener el archivo existente si no se sube uno nuevo
                $validated[$field] = $course->$field;
            } else {
                $validated[$field] = null;
            }
        }

        $validated['is_external_link'] = $request->has('is_external_link') ? true : false;
        $validated['is_free'] = $request->has('is_free') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['updated_by'] = Auth::id();

        $course->update($validated);
        return redirect()->route('courses.index')->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado exitosamente.');
    }
}

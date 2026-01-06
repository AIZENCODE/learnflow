<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        // Obtener o crear la única empresa (solo puede haber una)
        $company = Company::firstOrNew([]);
        return view('admin.companies.index', compact('company'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'color_hex' => 'nullable|string|max:7',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'logo_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'banner_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        // Obtener o crear la única empresa
        $company = Company::firstOrNew([]);

        // Asegurar que los campos requeridos por la BD tengan valores por defecto si vienen vacíos
        $validated['email'] = $validated['email'] ?? '';
        $validated['phone'] = $validated['phone'] ?? '';
        $validated['address'] = $validated['address'] ?? '';
        $validated['city'] = $validated['city'] ?? '';
        $validated['state'] = $validated['state'] ?? '';
        $validated['zip'] = $validated['zip'] ?? '';
        $validated['country'] = $validated['country'] ?? '';

        // Manejar subida de archivos
        $imageFields = ['logo_path', 'favicon_path', 'banner_path', 'background_path', 
                       'logo_path_dark', 'favicon_path_dark', 'banner_path_dark', 'background_path_dark'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $file = $request->file($field);
                    $filename = 'company_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    // Según la documentación: El FilesystemTenancyBootstrapper modifica automáticamente
                    // storage_path() y las raíces de los discos cuando el tenant se inicializa.
                    // El bootstrapper debería haber modificado storage_path() para que apunte a
                    // storage/tenant{id}/ y las raíces de los discos usando root_override.
                    
                    // Verificar que el tenant esté inicializado (el bootstrapper se ejecuta cuando se inicializa)
                    $tenant = tenancy()->tenant;
                    if (!$tenant) {
                        throw new \Exception('No hay tenant activo. Asegúrate de que el middleware InitializeTenancyByDomain se ejecute antes.');
                    }
                    
                    // El bootstrapper debería haber modificado storage_path() automáticamente
                    // storage_path() ahora debería retornar: storage/tenant{id}/
                    // Y el disco 'public' debería usar: storage/tenant{id}/app/public/
                    
                    // Debug temporal: verificar que storage_path() esté modificado
                    $currentStoragePath = storage_path();
                    $expectedTenantPath = 'tenant' . $tenant->id;
                    
                    if (strpos($currentStoragePath, $expectedTenantPath) === false) {
                        // El bootstrapper no modificó storage_path(), forzar la configuración manualmente
                        \Log::warning('FilesystemTenancyBootstrapper no modificó storage_path(). Forzando configuración manual.');
                        $tenantStoragePath = base_path('storage/' . $expectedTenantPath . '/app/public');
                        config(['filesystems.disks.public.root' => $tenantStoragePath]);
                        app()->forgetInstance('filesystem.disk.public');
                    }
                    
                    $disk = Storage::disk('public');
                    
                    // Asegurar que el directorio existe
                    if (!$disk->exists('companies')) {
                        $disk->makeDirectory('companies');
                    }
                    
                    // Guardar el archivo - el bootstrapper asegura que se guarde en storage/tenant{id}/app/public/companies/
                    $path = $disk->putFileAs('companies', $file, $filename);
                    
                    // Guardar solo la ruta relativa (companies/filename.jpg)
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    // Si hay error al guardar, mantener el valor existente o null
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage() . ' | Storage path: ' . storage_path());
                    $validated[$field] = $company->exists ? $company->$field : null;
                }
            } elseif ($company->exists && $company->$field) {
                // Mantener el valor existente si no se sube nuevo archivo
                $validated[$field] = $company->$field;
            } else {
                $validated[$field] = null;
            }
        }

        $company->fill($validated);
        $company->created_by = $company->created_by ?? Auth::id();
        $company->updated_by = Auth::id();
        $company->save();

        return redirect()->route('companies.index')
            ->with('success', 'Empresa guardada exitosamente.');
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'color_hex' => 'nullable|string|max:7',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'logo_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:1024',
            'banner_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'background_path_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        // Asegurar que los campos requeridos por la BD tengan valores por defecto si vienen vacíos
        $validated['email'] = $validated['email'] ?? '';
        $validated['phone'] = $validated['phone'] ?? '';
        $validated['address'] = $validated['address'] ?? '';
        $validated['city'] = $validated['city'] ?? '';
        $validated['state'] = $validated['state'] ?? '';
        $validated['zip'] = $validated['zip'] ?? '';
        $validated['country'] = $validated['country'] ?? '';

        // Manejar subida de archivos
        $imageFields = ['logo_path', 'favicon_path', 'banner_path', 'background_path', 
                       'logo_path_dark', 'favicon_path_dark', 'banner_path_dark', 'background_path_dark'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    // Verificar que el tenant esté inicializado
                    $tenant = tenancy()->tenant;
                    if (!$tenant) {
                        throw new \Exception('No hay tenant activo. Asegúrate de que el middleware InitializeTenancyByDomain se ejecute antes.');
                    }
                    
                    // Según la documentación: El FilesystemTenancyBootstrapper modifica automáticamente
                    // storage_path() y las raíces de los discos cuando el tenant se inicializa.
                    
                    // Debug temporal: verificar que storage_path() esté modificado
                    $currentStoragePath = storage_path();
                    $expectedTenantPath = 'tenant' . $tenant->id;
                    
                    if (strpos($currentStoragePath, $expectedTenantPath) === false) {
                        // El bootstrapper no modificó storage_path(), forzar la configuración manualmente
                        \Log::warning('FilesystemTenancyBootstrapper no modificó storage_path(). Forzando configuración manual.');
                        $tenantStoragePath = base_path('storage/' . $expectedTenantPath . '/app/public');
                        config(['filesystems.disks.public.root' => $tenantStoragePath]);
                        app()->forgetInstance('filesystem.disk.public');
                    }
                    
                    $disk = Storage::disk('public');
                    
                    // Eliminar archivo anterior si existe
                    if ($company->$field && $disk->exists($company->$field)) {
                        $disk->delete($company->$field);
                    }
                    
                    $file = $request->file($field);
                    $filename = 'company_' . $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    // Asegurar que el directorio existe
                    if (!$disk->exists('companies')) {
                        $disk->makeDirectory('companies');
                    }
                    
                    // Guardar el archivo - el bootstrapper asegura que se guarde en storage/tenant{id}/app/public/companies/
                    $path = $disk->putFileAs('companies', $file, $filename);
                    $validated[$field] = $path;
                } catch (\Exception $e) {
                    // Si hay error al guardar, mantener el valor existente
                    \Log::error('Error guardando archivo ' . $field . ': ' . $e->getMessage() . ' | Storage path: ' . storage_path());
                    $validated[$field] = $company->$field;
                }
            } else {
                // Mantener el valor existente si no se sube nuevo archivo
                $validated[$field] = $company->$field;
            }
        }

        $company->fill($validated);
        $company->updated_by = Auth::id();
        $company->save();

        return redirect()->route('companies.index')
            ->with('success', 'Empresa actualizada exitosamente.');
    }
}

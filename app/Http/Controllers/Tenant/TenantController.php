<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->paginate(15);
        return view('dashboard.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:tenants,id|max:255',
        ]);

        // return $request->all();

        $tenant = Tenant::create([
            'id' => $request->id,
            'is_active' => true, // Por defecto activo
        ]);
        $tenant->domains()->create([
            // 'domain' => $request->name . '.' . config('tenancy.central_domains')[0],
            // 'domain' => $request->id . '.learnflow.test',
            'domain' => $request->id . '.' . env('APP_TENANT_DOMAIN'),
        ]);
        return redirect()->route('tenants.index')->with('success', 'Inquilino creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return view('dashboard.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('dashboard.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'id' => 'required|string|unique:tenants,id,' . $tenant->id . '|max:255',
        ]);

        $tenant->update([
            'id' => $request->get('id')
        ]);

        // Actualizar el dominio del tenant
        $domain = $tenant->domains->first();
        if ($domain) {
            $domain->update([
                'domain' => $request->get('id') . '.' . env('APP_TENANT_DOMAIN'),
            ]);
        }

        return redirect()->route('tenants.index')->with('success', 'Inquilino actualizado exitosamente');
    }

    /**
     * Toggle the active status of the tenant.
     */
    public function toggleActive(Tenant $tenant)
    {
        $tenant->update([
            'is_active' => !$tenant->is_active,
        ]);

        $status = $tenant->is_active ? 'activado' : 'desactivado';
        return redirect()->route('tenants.index')->with('success', "Inquilino {$status} exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Inquilino eliminado exitosamente');
    }
}

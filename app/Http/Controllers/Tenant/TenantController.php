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
        $tenants = Tenant::all();
        return view('tenants.inquilinos.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.inquilinos.create');
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
        ]);
        $tenant->domains()->create([
            // 'domain' => $request->name . '.' . config('tenancy.central_domains')[0],
            'domain' => $request->id . '.learnflow.test',
        ]);
        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return view('tenants.inquilinos.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.inquilinos.edit', compact('tenant'));
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

        $tenant->domains()->update([
            'domain' => $request->get('id') . '.learnflow.test',
        ]);
        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully');
    }
}

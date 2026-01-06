<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        // Asegurar que los campos requeridos por la BD tengan valores por defecto si vienen vacíos
        $validated['email'] = $validated['email'] ?? '';
        $validated['phone'] = $validated['phone'] ?? '';
        $validated['address'] = $validated['address'] ?? '';
        $validated['city'] = $validated['city'] ?? '';
        $validated['state'] = $validated['state'] ?? '';
        $validated['zip'] = $validated['zip'] ?? '';
        $validated['country'] = $validated['country'] ?? '';

        $company->fill($validated);
        $company->updated_by = Auth::id();
        $company->save();

        return redirect()->route('companies.index')
            ->with('success', 'Empresa actualizada exitosamente.');
    }
}

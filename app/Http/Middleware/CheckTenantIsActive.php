<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenancy()->tenant;

        // Si no hay tenant inicializado, permitir continuar (puede ser dominio central)
        if (!$tenant) {
            return $next($request);
        }

        // Verificar si el tenant está activo
        if (!$tenant->is_active) {
            abort(403, 'Este inquilino está desactivado y no puede acceder al sistema.');
        }

        return $next($request);
    }
}

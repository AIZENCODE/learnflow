<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\TrackController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return view('admin.welcome');
    });


    Route::middleware('auth')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('tracks', TrackController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('roles', RolController::class);

    Route::get('general', [GeneralController::class, 'index'])->name('general.index');

    require __DIR__ . '/auth.php';
});


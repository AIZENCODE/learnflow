<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\Client\GeneralController;
use App\Http\Controllers\Admin\Client\CourseController as ClientCourseController;
use App\Http\Controllers\Admin\Client\TrackController as ClientTrackController;
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

    // Rutas de autenticación para tenant
    Route::middleware('guest')->group(function () {
        Route::get('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
        Route::get('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
        Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Rutas de perfil para tenant
        Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

        // Rutas de verificación de email
        Route::get('verify-email', \App\Http\Controllers\Auth\EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', \App\Http\Controllers\Auth\VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        // Rutas de contraseña
        Route::get('confirm-password', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store']);
        Route::put('password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

        // Logout
        Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('tracks', TrackController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('roles', RolController::class);

    Route::get('general', [GeneralController::class, 'index'])->name('general.index');

    // Rutas para clientes
    Route::get('client/courses/{course}', [ClientCourseController::class, 'show'])->name('client.courses.show');
    Route::get('client/tracks/{track}', [ClientTrackController::class, 'show'])->name('client.tracks.show');

    // Vistas index para clientes
    Route::get('client/tracks', function() {
        $tracks = \App\Models\Track::withCount('courses')
            ->orderBy('order')
            ->get();
        $company = \App\Models\Company::first();
        return view('admin.clients.tracks.index', compact('tracks', 'company'));
    })->name('client.tracks.index');

    Route::get('client/courses', function() {
        $courses = \App\Models\Course::where('is_published', true)
            ->with('track')
            ->withCount('lessons')
            ->orderBy('order_in_track')
            ->get();
        $company = \App\Models\Company::first();
        return view('admin.clients.courses.index', compact('courses', 'company'));
    })->name('client.courses.index');
});


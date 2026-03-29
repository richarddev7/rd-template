<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/flux/flux.js', function () {
    $path = base_path('vendor/livewire/flux/dist/flux-lite.min.js');

    if (file_exists($path)) {
        $content = file_get_contents($path);
        return response($content, 200, [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    abort(404);
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Settings routes (User Profile, Password, Appearance, 2FA)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Admin routes
Route::prefix('app')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('dashboard', \App\Livewire\Dashboard::class)
        ->middleware(['verified'])
        ->name('dashboard');

    // Roles & Permissions
    Route::get('roles', \App\Livewire\Roles\RoleList::class)->name('roles.index');
    Route::get('roles/create', \App\Livewire\Roles\RoleForm::class)->name('roles.create');
    Route::get('roles/{role}/edit', \App\Livewire\Roles\RoleForm::class)->name('roles.edit');

    // Users
    Route::get('users', \App\Livewire\Users\UserList::class)->name('users.index');
    Route::get('users/create', \App\Livewire\Users\UserForm::class)->name('users.create');
    Route::get('users/{user}/edit', \App\Livewire\Users\UserForm::class)->name('users.edit');

    // Impersonation (Super Admin only)
    Route::post('impersonate/stop', [\App\Http\Controllers\ImpersonationController::class, 'stop'])
        ->name('impersonate.stop');
    Route::post('impersonate/{user}', [\App\Http\Controllers\ImpersonationController::class, 'start'])
        ->middleware('role:Super Admin')
        ->name('impersonate.start');

    // Clients 
    Route::get('clients', \App\Livewire\Clients\ClientList::class)->name('clients.index');
    Route::get('clients/create', \App\Livewire\Clients\ClientForm::class)->name('clients.create');
    Route::get('clients/{client}', \App\Livewire\Clients\ClientOverview::class)
        ->middleware('can:view clients')
        ->name('clients.show');
    Route::get('clients/{client}/edit', \App\Livewire\Clients\ClientForm::class)->name('clients.edit');

    // Client Requests
    Route::get('client-requests', \App\Livewire\ClientRequests\ClientRequestList::class)
        ->middleware('can:view requests')
        ->name('client-requests.index');
    Route::get('client-requests/create', \App\Livewire\ClientRequests\ClientRequestForm::class)
        ->middleware('can:create requests')
        ->name('client-requests.create');
    Route::get('client-requests/{clientRequest}/edit', \App\Livewire\ClientRequests\ClientRequestForm::class)
        ->middleware('can:edit requests')
        ->name('client-requests.edit');
    Route::get('client-requests/{clientRequest}', \App\Livewire\ClientRequests\ClientRequestShow::class)
        ->middleware('can:view requests')
        ->name('client-requests.show');

    // Application Settings (Superadmin only)
    Route::get('settings', \App\Livewire\Settings\AppSettings::class)
        ->middleware('role:Super Admin')
        ->name('settings.app');
});

// Client Portal
Route::prefix('portal')->middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('dashboard', \App\Livewire\Portal\Dashboard::class)->name('portal.dashboard');
    Route::get('solicitudes', \App\Livewire\Portal\MyRequests::class)->name('portal.requests');
    Route::get('solicitudes/{clientRequest}', \App\Livewire\Portal\RequestShow::class)->name('portal.requests.show');
    Route::get('perfil', \App\Livewire\Portal\Profile::class)->name('portal.profile');
});

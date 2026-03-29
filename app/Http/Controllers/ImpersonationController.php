<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Start impersonating a user
     */
    public function start(Request $request, User $user)
    {
        // Verificar que el usuario actual es Super Admin
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Prevenir auto-suplantación
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', __('You cannot impersonate yourself'));
        }

        // Prevenir suplantación en cadena
        if ($request->session()->has('impersonating')) {
            return redirect()->back()->with('error', __('You cannot impersonate while already impersonating'));
        }

        // Guardar el ID del usuario original en la sesión
        $request->session()->put('impersonating', Auth::id());

        // Autenticar como el usuario objetivo
        Auth::login($user);

        // If the target is a client user, redirect to their portal; else normal dashboard
        $destination = $user->hasRole('Cliente')
            ? redirect()->route('portal.dashboard')
            : redirect()->route('dashboard');

        return $destination->with('success', __('Impersonation started successfully'));
    }

    /**
     * Stop impersonating and return to original user
     */
    public function stop(Request $request)
    {
        // Verificar que hay una suplantación activa
        if (!$request->session()->has('impersonating')) {
            return redirect()->route('dashboard');
        }

        // Obtener el ID del usuario original
        $originalUserId = $request->session()->get('impersonating');

        // Eliminar la marca de suplantación de la sesión
        $request->session()->forget('impersonating');

        // Autenticar como el usuario original
        $originalUser = User::findOrFail($originalUserId);
        Auth::login($originalUser);

        return redirect()->route('dashboard')->with('success', __('Impersonation stopped successfully'));
    }
}

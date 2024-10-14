<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;  


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }


    public function toggleSuperAdmin(User $user)
{
    // Verificar si el usuario es un manager
    if (!$user->is_manager) {
        return back()->with('error', 'Solo los managers pueden ser promovidos a SuperAdmin.');
    }

    // Cambiar el estado de is_superadmin
    $user->is_superadmin = !$user->is_superadmin; // Alternar el valor
    $user->save();

    $action = $user->is_superadmin ? 'promovido a' : 'degradado de';
    return back()->with('status', "El usuario ha sido {$action} SuperAdmin exitosamente.");
}



    public function edit(Request $request): View
    {
        $user = $request->user();
        $empleados = [];
        
        if ($user->tipo_usuario === 'empleador') {
            $empleados = $user->empleados;
        }

        return view('profile.edit', [
            'user' => $user,
            'empleados' => $empleados,
        ]);
    }

    public function promoverAManager(User $user)
    {
        if ($user->tipo_usuario === 'empleado' && !$user->is_manager) {
            $user->promoverAManager();
            return redirect()->back()->with('success', 'Usuario promovido a manager exitosamente.');
        }
        return redirect()->back()->with('error', 'No se pudo promover al usuario a manager.');
    }

    public function degradarDeManager(User $user)
    {
        if ($user->tipo_usuario === 'empleado' && $user->is_manager) {
            $user->degradarDeManager();
            return redirect()->back()->with('success', 'Manager degradado a empleado regular exitosamente.');
        }
        return redirect()->back()->with('error', 'No se pudo degradar al manager.');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

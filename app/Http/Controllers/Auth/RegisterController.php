<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Muestra la vista de registro
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * proceso de registro de un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'string', 'in:admin,empleado'], // validamos rol
        ]);

        // Crea usuario
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asigna un rol con Spatie
        $user->assignRole($request->role);

        // ventana de evento de registro
        event(new Registered($user));

        // Autenticador
        Auth::login($user);

        // Redirecciona
        return redirect()->route('home');
    }
}

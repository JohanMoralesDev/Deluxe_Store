<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|max:150|unique:usuarios,correo',
            'contrasena' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $usuario = DB::transaction(function () use ($datos) {

            $rol = Role::where('nombre', 'CLIENTE')->firstOrFail();

            $usuario = User::create([
                'nombre' => $datos['nombre'],
                'correo' => $datos['correo'],
                'contrasena' => $datos['contrasena'],
                'esta_activo' => true,
            ]);

            $usuario->roles()->attach($rol->id_rol, [
                'creado_en' => now(),
            ]);

            return $usuario;
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('store.index')
            ->with('success', '¡Bienvenido a Deluxe Store!');
    }
}

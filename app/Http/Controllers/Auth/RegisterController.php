<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
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
            'nombre' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150', 'unique:usuarios,correo'],
            'correo' => ['nullable', 'email', 'max:150', 'unique:usuarios,correo'],
            'password' => ['nullable', 'confirmed', 'string', Password::min(8)],
            'contrasena' => ['nullable', 'confirmed', 'string', Password::min(8)],
        ]);

        $correo = $datos['email'] ?? $datos['correo'] ?? null;
        $contrasena = $datos['password'] ?? $datos['contrasena'] ?? null;

        if (! $correo || ! $contrasena) {
            return back()
                ->withErrors(['register' => 'Completa el correo y la contraseña.'])
                ->withInput($request->except(['password', 'contrasena', 'password_confirmation', 'contrasena_confirmation']))
                ->with('abrir_modal', 'register');
        }

        $usuario = DB::transaction(function () use ($datos, $correo, $contrasena) {
            $usuario = User::create([
                'nombre' => $datos['nombre'],
                'correo' => $correo,
                'contrasena' => $contrasena,
                'esta_activo' => true,
            ]);

            $rol = Role::where('nombre', 'CLIENTE')->first();
            if ($rol) {
                $usuario->roles()->attach($rol->id_rol, ['creado_en' => now()]);
            }

            return $usuario;
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()
            ->route('store.index')
            ->with('success', '¡Tu cuenta ha sido creada correctamente!');
    }
}

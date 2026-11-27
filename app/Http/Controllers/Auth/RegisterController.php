<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $nombre = preg_replace('/\s+/u', ' ', trim((string) $request->input('nombre')));
        $request->merge([
            'nombre' => $nombre,
            'email' => $request->input('email', $request->input('correo')),
            'password' => $request->input('password', $request->input('contrasena')),
            'password_confirmation' => $request->input('password_confirmation', $request->input('contrasena_confirmation')),
        ]);
        $request->request->remove('contrasena');
        $request->request->remove('contrasena_confirmation');

        try {
            $datos = $request->validate([
                'nombre' => ['required', 'string', 'min:2', 'max:150', 'regex:/\A[\p{L}\p{M}]+(?:[ \'\x{2019}-][\p{L}\p{M}]+)*\z/u'],
                'email' => ['required', 'email:rfc', 'max:150', 'unique:usuarios,correo'],
                'password' => ['required', 'string', Password::min(8)->letters()->numbers()],
                'password_confirmation' => ['required', 'same:password'],
            ], [
                'nombre.required' => 'Escribe tu nombre completo.',
                'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
                'nombre.regex' => 'Usa solo letras, espacios, apóstrofes o guiones en el nombre.',
                'email.required' => 'Escribe tu correo electrónico.',
                'email.email' => 'Escribe un correo electrónico válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'password.required' => 'Crea una contraseña.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.letters' => 'La contraseña debe incluir al menos una letra.',
                'password.numbers' => 'La contraseña debe incluir al menos un número.',
                'password_confirmation.required' => 'Confirma tu contraseña.',
                'password_confirmation.same' => 'La confirmación de contraseña no coincide.',
            ]);
        } catch (ValidationException $exception) {
            $response = back()
                ->withErrors($exception->errors())
                ->withInput($request->except(['password', 'password_confirmation', 'contrasena', 'contrasena_confirmation']));

            return $request->routeIs('auth.register.store')
                ? $response->with('abrir_modal', 'register')
                : $response;
        }

        $usuario = DB::transaction(function () use ($datos) {
            $usuario = User::create([
                'nombre' => $datos['nombre'],
                'correo' => $datos['email'],
                'contrasena' => Hash::make($datos['password']),
                'esta_activo' => true,
            ]);

            $rol = Role::firstOrCreate(
                ['nombre' => 'CLIENTE'],
                ['descripcion' => 'Cuenta de cliente']
            );
            $usuario->roles()->syncWithoutDetaching([$rol->id_rol => ['creado_en' => now()]]);

            return $usuario;
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()
            ->route('store.index')
            ->with('success', '¡Tu cuenta ha sido creada correctamente!');
    }
}

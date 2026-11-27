<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.index', ['usuario' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $usuario = $request->user();
        $nombre = preg_replace('/\s+/u', ' ', trim((string) $request->input('nombre')));
        $request->merge([
            'nombre' => $nombre,
            'correo' => $request->input('email', $request->input('correo')),
        ]);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:150', 'regex:/\A[\p{L}\p{M}]+(?:[ \'\x{2019}-][\p{L}\p{M}]+)*\z/u'],
            'correo' => ['required', 'email:rfc', 'max:150', Rule::unique('usuarios', 'correo')->ignore($usuario->getKey(), 'id_usuario')],
            'current_password' => ['required', 'string'],
            'telefono' => ['nullable', 'string', 'max:25'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'departamento' => ['nullable', 'string', 'max:100'],
        ], [
            'nombre.required' => 'Escribe tu nombre completo.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.regex' => 'Usa solo letras, espacios, apóstrofes o guiones en el nombre.',
            'correo.required' => 'Escribe tu correo electrónico.',
            'correo.email' => 'Escribe un correo electrónico válido.',
            'correo.unique' => 'Este correo ya está registrado.',
            'current_password.required' => 'Escribe tu contraseña actual para confirmar los cambios.',
        ]);

        if (! Hash::check($datos['current_password'], $usuario->getAuthPassword())) {
            return back()
                ->withErrors(['current_password' => 'La contraseña actual es incorrecta.'])
                ->withInput($request->except(['current_password', 'contrasena_actual', 'password', 'contrasena', 'password_confirmation', 'contrasena_confirmation']));
        }

        unset($datos['current_password']);
        $usuario->update($datos);

        return redirect()->route('account.show')->with('success', 'La información de tu cuenta se actualizó correctamente.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'different:current_password', Password::min(8)->letters()->numbers()],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'current_password.required' => 'Escribe tu contraseña actual.',
            'password.required' => 'Escribe una contraseña nueva.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La nueva contraseña debe incluir al menos una letra.',
            'password.numbers' => 'La nueva contraseña debe incluir al menos un número.',
            'password.different' => 'La nueva contraseña debe ser diferente de la actual.',
            'password_confirmation.required' => 'Confirma la nueva contraseña.',
            'password_confirmation.same' => 'La confirmación de contraseña no coincide.',
        ]);

        $usuario = $request->user();
        if (! Hash::check($datos['current_password'], $usuario->getAuthPassword())) {
            return back()
                ->withErrors(['current_password' => 'La contraseña actual es incorrecta.'])
                ->withInput($request->except(['current_password', 'contrasena_actual', 'password', 'contrasena', 'password_confirmation', 'contrasena_confirmation']));
        }

        Auth::logoutOtherDevices($datos['current_password']);
        $usuario->forceFill(['contrasena' => Hash::make($datos['password'])])->save();
        $request->session()->regenerate();

        return redirect()->route('account.show')->with('success', 'Tu contraseña se actualizó correctamente.');
    }
}

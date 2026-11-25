<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'email' => ['nullable', 'email'],
            'correo' => ['nullable', 'email'],
            'password' => ['nullable', 'string'],
            'contrasena' => ['nullable', 'string'],
        ]);

        $correo = $datos['email'] ?? $datos['correo'] ?? null;
        $contrasena = $datos['password'] ?? $datos['contrasena'] ?? null;

        if (! $correo || ! $contrasena) {
            return back()
                ->withErrors(['login' => 'Debes ingresar el correo y la contraseña.'])
                ->withInput($request->only('email', 'correo'))
                ->with('abrir_modal', 'login');
        }

        $credenciales = [
            'correo' => $correo,
            'password' => $contrasena,
            'esta_activo' => true,
        ];

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('store.index'))
                ->with('success', '¡Bienvenido a Deluxe Store!');
        }

        return back()
            ->withErrors(['login' => 'El correo o la contraseña son incorrectos.'])
            ->withInput($request->only('email', 'correo'))
            ->with('abrir_modal', 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('store.index')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}

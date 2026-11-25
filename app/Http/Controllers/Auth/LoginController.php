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
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        $credenciales = [
            'correo' => $datos['correo'],
            'password' => $datos['contrasena'],
            'esta_activo' => true,
        ];

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {

            $request->session()->regenerate();

            return redirect()->intended(route('store.index'));
        }

        return back()
            ->withErrors([
                'correo' => 'Correo o contraseña incorrectos, o cuenta inactiva.',
            ])
            ->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('store.index')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}
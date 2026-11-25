<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Procesar el inicio de sesión.
     */
    public function login(Request $request)
    {
        // 1. Validar los datos recibidos del formulario.
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Preparar las credenciales para Laravel.
        $datosAcceso = [
            'correo' => $credenciales['email'],
            'password' => $credenciales['password'],
            'esta_activo' => true,
        ];

        // 3. Comprobar las credenciales e iniciar sesión.
        if (Auth::attempt($datosAcceso)) {

            // 4. Regenerar la sesión por seguridad.
            $request->session()->regenerate();

            // 5. Redirigir al usuario.
            return redirect()
                ->intended(route('store.index'))
                ->with('success', '¡Bienvenido a Deluxe Store!');
        }

        // 6. Si los datos son incorrectos, regresar al formulario.
        return back()
            ->withErrors([
                'login' => 'El correo o la contraseña son incorrectos.',
            ])
            ->withInput($request->only('email'))
            ->with('abrir_modal', 'login');
    }

    /**
     * Cerrar la sesión.
     */
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

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Registrar un usuario nuevo.
     */
    public function register(Request $request)
    {
        // 1. Validar los datos recibidos.
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,correo'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Crear el usuario.
        $usuario = User::create([
            'nombre' => $datos['nombre'],
            'correo' => $datos['email'],
            'contrasena' => $datos['password'],
            'esta_activo' => true,
        ]);

        // 3. Iniciar sesión automáticamente.
        Auth::login($usuario);

        // 4. Regenerar la sesión.
        $request->session()->regenerate();

        // 5. Redirigir al inicio.
        return redirect()
            ->route('store.index')
            ->with('success', '¡Tu cuenta ha sido creada correctamente!');
    }
}

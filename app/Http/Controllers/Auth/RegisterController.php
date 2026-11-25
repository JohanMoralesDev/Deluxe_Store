
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    // Mostrar formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Registrar usuario
    public function register(Request $request)
    {
        // Validar información
        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|max:150|unique:usuarios,correo',
            'contrasena' => 'required|string|min:8|confirmed',
        ]);

        // Buscar el rol de cliente
        $rol = Role::where('nombre', 'CLIENTE')->firstOrFail();

        // Crear usuario y asignar rol
        $usuario = DB::transaction(function () use ($request, $rol) {

            $nuevoUsuario = User::create([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'contrasena' => $request->contrasena,
                'esta_activo' => true,
            ]);

            $nuevoUsuario->roles()->attach($rol->id_rol);

            return $nuevoUsuario;
        });

        // Iniciar sesión
        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect('/')->with(
            'success',
            '¡Bienvenido a Deluxe Store!'
        );
    }
}

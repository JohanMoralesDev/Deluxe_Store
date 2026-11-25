<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Mostrar perfil
    public function index()
    {
        $usuario = Auth::user();

        return view('profile.index', compact('usuario'));
    }

    // Actualizar perfil
    public function update(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
        ]);

        $usuario->update($datos);

        return redirect()->route('profile.index')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}

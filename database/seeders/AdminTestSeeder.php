<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AdminTestSeeder extends Seeder
{
    public function run(): void
    {
        // Comprobar si la creación del administrador está habilitada.
        if (!filter_var(env('ADMIN_TEMP_ENABLED', false), FILTER_VALIDATE_BOOLEAN)) {
            $this->command->warn('La creación del administrador temporal está desactivada.');
            return;
        }

        // Obtener las credenciales desde el archivo .env.
        $nombre = env('ADMIN_TEMP_NAME');
        $correo = env('ADMIN_TEMP_EMAIL');
        $contrasena = env('ADMIN_TEMP_PASSWORD');

        if (!$nombre || !$correo || !$contrasena) {
            throw new RuntimeException(
                'Faltan las credenciales ADMIN_TEMP en el archivo .env.'
            );
        }

        if (strlen($contrasena) < 8) {
            throw new RuntimeException(
                'La contraseña del administrador debe tener al menos 8 caracteres.'
            );
        }

        DB::transaction(function () use ($nombre, $correo, $contrasena) {

            // Buscar el rol administrador existente.
            $rolAdmin = Role::where('nombre', 'ADMINISTRADOR')->first();

            if (!$rolAdmin) {
                throw new RuntimeException(
                    'No existe el rol ADMINISTRADOR en la tabla roles.'
                );
            }

            // Buscar la cuenta de pruebas.
            $usuario = User::where('correo', $correo)->first();

            if (!$usuario) {
                // Crear el administrador.
                // El cast "hashed" de User cifra la contraseña automáticamente.
                $usuario = User::create([
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'contrasena' => $contrasena,
                    'esta_activo' => true,
                ]);

                $this->command->info('Administrador de pruebas creado.');
            } else {
                // No modificar ni elevar automáticamente una cuenta existente.
                if (!$usuario->roles()->where('roles.id_rol', $rolAdmin->id_rol)->exists()) {
                    throw new RuntimeException(
                        'El correo de pruebas ya pertenece a una cuenta sin rol administrador. Revisa esa cuenta antes de continuar.'
                    );
                }

                $this->command->info('La cuenta administradora ya existe.');
            }

            // Asignar el rol sin duplicar la relación.
            $usuario->roles()->syncWithoutDetaching([
                $rolAdmin->id_rol
            ]);

            $this->command->info('Rol ADMINISTRADOR verificado correctamente.');
        });
    }
}

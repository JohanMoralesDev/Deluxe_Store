<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class Role extends Model
{
    use HasRelationships;

    // Tabla de roles
    protected $table = 'roles';

    // Clave primaria
    protected $primaryKey = 'id_rol';

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Relación con usuarios
    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'usuario_rol',
            'id_rol',
            'id_usuario',
            'id_rol',
            'id_usuario'
        );
    }
}

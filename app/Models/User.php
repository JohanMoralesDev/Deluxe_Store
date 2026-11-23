<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabla real en MySQL
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id_usuario';

    // Tipo de clave primaria
    protected $keyType = 'int';

    public $incrementing = true;

    // Nombres de las columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'telefono',
        'direccion',
        'ciudad',
        'departamento',
        'esta_activo',
    ];

    // Campos que no deben exponerse al serializar el usuario
    protected $hidden = [
        'contrasena',
        'token_recordatorio',
    ];

    // Adaptación de la contraseña
    public function getAuthPasswordName(): string
    {
        return 'contrasena';
    }

    // Adaptación del token de sesión persistente
    public function getRememberTokenName(): string
    {
        return 'token_recordatorio';
    }

    // Conversión automática de tipos
    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'esta_activo' => 'boolean',
            'correo_verificado_en' => 'datetime',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    public function roles(): BelongsToMany
{
    return $this->belongsToMany(
        Role::class,
        'usuario_rol',
        'id_usuario',
        'id_rol',
        'id_usuario',
        'id_rol'
    );
}
}


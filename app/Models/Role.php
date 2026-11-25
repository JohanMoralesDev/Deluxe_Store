<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuarios(): BelongsToMany
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

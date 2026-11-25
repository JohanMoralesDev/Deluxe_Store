<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Tabla de la base de datos
    protected $table = 'categorias';

    // Llave primaria
    protected $primaryKey = 'id_categoria';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'esta_activa',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'esta_activa' => 'boolean',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: una categoría tiene muchos productos
    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'id_categoria',
            'id_categoria'
        );
    }
}

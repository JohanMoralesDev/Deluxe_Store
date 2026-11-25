<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    // Tabla de la base de datos
    protected $table = 'proveedores';

    // Llave primaria
    protected $primaryKey = 'id_proveedor';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'persona_contacto',
        'esta_activo',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'esta_activo' => 'boolean',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: un proveedor tiene muchas recepciones
    public function receptions(): HasMany
    {
        return $this->hasMany(
            SupplierReception::class,
            'id_proveedor',
            'id_proveedor'
        );
    }
}

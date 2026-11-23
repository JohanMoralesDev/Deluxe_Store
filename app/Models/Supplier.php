<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'proveedores';

    protected $primaryKey = 'id_proveedor';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'persona_contacto',
        'esta_activo',
    ];

    protected function casts(): array
    {
        return [
            'esta_activo' => 'boolean',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    public function receptions(): HasMany
    {
        return $this->hasMany(
            SupplierReception::class,
            'id_proveedor',
            'id_proveedor'
        );
    }
}
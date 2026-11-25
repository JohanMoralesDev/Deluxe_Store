<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierReception extends Model
{
    // Tabla de la base de datos
    protected $table = 'recepciones_proveedor';

    // Llave primaria
    protected $primaryKey = 'id_recepcion_proveedor';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_proveedor',
        'id_usuario',
        'numero_recepcion',
        'fecha_recepcion',
        'costo_total',
        'observaciones',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'id_usuario' => 'integer',
            'fecha_recepcion' => 'datetime',
            'costo_total' => 'decimal:2',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: una recepción pertenece a un proveedor
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            Supplier::class,
            'id_proveedor',
            'id_proveedor'
        );
    }

    // Relación: una recepción pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    // Relación: una recepción tiene muchos detalles
    public function details(): HasMany
    {
        return $this->hasMany(
            SupplierReceptionDetail::class,
            'id_recepcion_proveedor',
            'id_recepcion_proveedor'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierReceptionDetail extends Model
{
    // Tabla de la base de datos
    protected $table = 'detalle_recepcion_proveedor';

    // Llave primaria
    protected $primaryKey = 'id_detalle_recepcion';

    protected $keyType = 'int';

    public $incrementing = true;

    // No utiliza timestamps automáticos
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_recepcion_proveedor',
        'id_producto',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'costo_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Relación: pertenece a una recepción
    public function reception(): BelongsTo
    {
        return $this->belongsTo(
            SupplierReception::class,
            'id_recepcion_proveedor',
            'id_recepcion_proveedor'
        );
    }

    // Relación: pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }
}

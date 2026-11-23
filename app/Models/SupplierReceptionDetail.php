<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierReceptionDetail extends Model
{
    protected $table = 'detalle_recepcion_proveedor';

    protected $primaryKey = 'id_detalle_recepcion';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_recepcion_proveedor',
        'id_producto',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'costo_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function reception(): BelongsTo
    {
        return $this->belongsTo(
            SupplierReception::class,
            'id_recepcion_proveedor',
            'id_recepcion_proveedor'
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }
}
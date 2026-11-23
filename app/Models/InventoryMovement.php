<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $table = 'movimientos_inventario';

    protected $primaryKey = 'id_movimiento_inventario';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'id_usuario',
        'id_pedido',
        'id_recepcion_proveedor',
        'tipo_movimiento',
        'cantidad',
        'stock_anterior',
        'stock_nuevo',
        'descripcion',
        'fecha_movimiento',
    ];

    protected function casts(): array
    {
        return [
            'id_usuario' => 'integer',
            'id_pedido' => 'integer',
            'id_recepcion_proveedor' => 'integer',
            'cantidad' => 'integer',
            'stock_anterior' => 'integer',
            'stock_nuevo' => 'integer',
            'fecha_movimiento' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'id_pedido',
            'id_pedido'
        );
    }

    public function supplierReception(): BelongsTo
{
    return $this->belongsTo(
        SupplierReception::class,
        'id_recepcion_proveedor',
        'id_recepcion_proveedor'
    );
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    // Tabla de la base de datos
    protected $table = 'movimientos_inventario';

    // Llave primaria
    protected $primaryKey = 'id_movimiento_inventario';

    protected $keyType = 'int';

    public $incrementing = true;

    // No utiliza timestamps automáticos
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
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

    // Conversión automática de datos
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

    // Relación: pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }

    // Relación: pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    // Relación: pertenece a un pedido
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'id_pedido',
            'id_pedido'
        );
    }

    // Relación: pertenece a una recepción de proveedor
    public function supplierReception(): BelongsTo
    {
        return $this->belongsTo(
            SupplierReception::class,
            'id_recepcion_proveedor',
            'id_recepcion_proveedor'
        );
    }
}

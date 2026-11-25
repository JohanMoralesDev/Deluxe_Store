<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    // Tabla de la base de datos
    protected $table = 'detalle_pedido';

    // Llave primaria
    protected $primaryKey = 'id_detalle';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_pedido',
        'id_producto',
        'nombre_producto',
        'codigo_sku',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: el detalle pertenece a un pedido
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'id_pedido',
            'id_pedido'
        );
    }

    // Relación: el detalle pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }
}

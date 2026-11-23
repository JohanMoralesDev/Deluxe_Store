<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'pedidos';

    protected $primaryKey = 'id_pedido';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'id_usuario',
        'numero_pedido',
        'estado',
        'estado_pago',
        'metodo_pago',
        'subtotal',
        'costo_envio',
        'descuento',
        'total',
        'nombre_destinatario',
        'telefono_destinatario',
        'direccion_envio',
        'ciudad_envio',
        'departamento_envio',
        'observaciones',
        'fecha_pedido',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'costo_envio' => 'decimal:2',
            'descuento' => 'decimal:2',
            'total' => 'decimal:2',
            'fecha_pedido' => 'datetime',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            OrderDetail::class,
            'id_pedido',
            'id_pedido'
        );
    }
    public function statusHistory(): HasMany
{
    return $this->hasMany(
        OrderStatusHistory::class,
        'id_pedido',
        'id_pedido'
    );
}
}
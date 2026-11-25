<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Tabla de la base de datos
    protected $table = 'pedidos';

    // Llave primaria
    protected $primaryKey = 'id_pedido';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
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

    // Conversión automática de datos
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

    // Relación: un pedido pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    // Relación: un pedido tiene muchos detalles
    public function details(): HasMany
    {
        return $this->hasMany(
            OrderDetail::class,
            'id_pedido',
            'id_pedido'
        );
    }

    // Relación: un pedido tiene un historial de estados
    public function statusHistory(): HasMany
    {
        return $this->hasMany(
            OrderStatusHistory::class,
            'id_pedido',
            'id_pedido'
        );
    }
}

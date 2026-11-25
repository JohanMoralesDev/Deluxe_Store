<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    // Tabla de la base de datos
    protected $table = 'historial_estados_pedido';

    // Llave primaria
    protected $primaryKey = 'id_historial_pedido';

    protected $keyType = 'int';

    public $incrementing = true;

    // No utiliza timestamps automáticos
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_pedido',
        'id_usuario',
        'estado_anterior',
        'estado_nuevo',
        'comentario',
        'fecha_cambio',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'id_usuario' => 'integer',
            'fecha_cambio' => 'datetime',
        ];
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

    // Relación: pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }
}

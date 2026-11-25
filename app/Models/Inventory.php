<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    // Tabla de la base de datos
    protected $table = 'inventarios';

    // Llave primaria
    protected $primaryKey = 'id_inventario';

    protected $keyType = 'int';

    public $incrementing = true;

    // Configuración de fechas
    public const CREATED_AT = null;
    public const UPDATED_AT = 'actualizado_en';

    public $timestamps = true;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_producto',
        'cantidad',
        'stock_minimo',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'stock_minimo' => 'integer',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: el inventario pertenece a un producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_producto',
            'id_producto'
        );
    }
}

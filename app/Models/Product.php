<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    // Tabla de la base de datos
    protected $table = 'productos';

    // Llave primaria
    protected $primaryKey = 'id_producto';

    protected $keyType = 'int';

    public $incrementing = true;

    // Columnas de fechas
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_categoria',
        'nombre',
        'codigo_sku',
        'descripcion',
        'precio',
        'precio_oferta',
        'color',
        'url_imagen',
        'esta_activo',
    ];

    // Conversión automática de datos
    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'precio_oferta' => 'decimal:2',
            'esta_activo' => 'boolean',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    // Relación: un producto pertenece a una categoría
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'id_categoria',
            'id_categoria'
        );
    }

    // Relación: un producto tiene un registro de inventario
    public function inventory(): HasOne
    {
        return $this->hasOne(
            Inventory::class,
            'id_producto',
            'id_producto'
        );
    }
}

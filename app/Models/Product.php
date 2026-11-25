<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = 'productos';

    protected $primaryKey = 'id_producto';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

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

    public function getIdAttribute(): int
    {
        return (int) $this->getKey();
    }

    public function getNameAttribute(): string
    {
        return (string) ($this->attributes['nombre'] ?? '');
    }

    public function getActiveAttribute(): bool
    {
        return (bool) ($this->attributes['esta_activo'] ?? false);
    }

    public function getPriceAttribute(): float
    {
        $offer = $this->attributes['precio_oferta'] ?? null;
        $price = $offer !== null && (float) $offer > 0
            ? $offer
            : ($this->attributes['precio'] ?? 0);

        return (float) $price;
    }

    public function getStockAttribute(): int
    {
        if (array_key_exists('stock', $this->attributes)) {
            return (int) $this->attributes['stock'];
        }

        return (int) ($this->inventory?->cantidad ?? 0);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'id_categoria',
            'id_categoria'
        );
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(
            'App\\Models\\Inventory',
            'id_producto',
            'id_producto'
        );
    }
}
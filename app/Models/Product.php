<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'publico',
        'tamano_esfera',
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
        $original = (float) ($this->attributes['precio'] ?? 0);
        $offer = $this->attributes['precio_oferta'] ?? null;
        $hasValidOffer = $offer !== null && (float) $offer > 0 && (float) $offer < $original;

        return $hasValidOffer ? (float) $offer : $original;
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
            Inventory::class,
            'id_producto',
            'id_producto'
        );
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(
            OrderDetail::class,
            'id_producto',
            'id_producto'
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('esta_activo', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, fn ($q) => $q->where(fn ($q) => $q
            ->where('nombre', 'like', "%{$term}%")
            ->orWhere('descripcion', 'like', "%{$term}%")
            ->orWhere('codigo_sku', 'like', "%{$term}%")));
    }

    public function getImageUrlAttribute(): string
    {
        return asset($this->url_imagen ?: 'assets/Imagenes/Logo.png');
    }

    public function getHasOfferAttribute(): bool
    {
        $offer = (float) ($this->attributes['precio_oferta'] ?? 0);

        return $offer > 0 && $offer < (float) ($this->attributes['precio'] ?? 0);
    }

    public function getDiscountPercentAttribute(): int
    {
        if (! $this->has_offer) {
            return 0;
        }

        $original = (float) $this->attributes['precio'];
        $offer = (float) $this->attributes['precio_oferta'];

        return max(1, (int) round((($original - $offer) / $original) * 100));
    }
}

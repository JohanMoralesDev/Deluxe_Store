<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventarios';

    protected $primaryKey = 'id_inventario';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = null;
    public const UPDATED_AT = 'actualizado_en';

public $timestamps = true;

    protected $fillable = [
        'id_producto',
        'cantidad',
        'stock_minimo',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'stock_minimo' => 'integer',
            'actualizado_en' => 'datetime',
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
}

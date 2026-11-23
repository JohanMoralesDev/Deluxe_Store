<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierReception extends Model
{
    protected $table = 'recepciones_proveedor';

    protected $primaryKey = 'id_recepcion_proveedor';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'id_proveedor',
        'id_usuario',
        'numero_recepcion',
        'fecha_recepcion',
        'costo_total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'id_usuario' => 'integer',
            'fecha_recepcion' => 'datetime',
            'costo_total' => 'decimal:2',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            Supplier::class,
            'id_proveedor',
            'id_proveedor'
        );
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
            SupplierReceptionDetail::class,
            'id_recepcion_proveedor',
            'id_recepcion_proveedor'
        );
    }
}
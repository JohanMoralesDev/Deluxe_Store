<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id_categoria';

    protected $keyType = 'int';

    public $incrementing = true;

    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'descripcion',
        'esta_activa',
    ];

    protected function casts(): array
    {
        return [
            'esta_activa' => 'boolean',
            'creado_en' => 'datetime',
            'actualizado_en' => 'datetime',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(
            'App\\Models\\Product',
            'id_categoria',
            'id_categoria'
        );
    }
}

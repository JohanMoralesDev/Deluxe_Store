<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_categoria' => ['required', 'integer', Rule::exists('categorias', 'id_categoria')->where('esta_activa', true)],
            'nombre' => ['required', 'string', 'max:150'],
            'codigo_sku' => ['required', 'string', 'max:80', Rule::unique('productos', 'codigo_sku')],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0', 'lt:precio'],
            'color' => ['nullable', 'string', 'max:50'],
            'url_imagen' => ['nullable', 'string', 'max:500'],
            'publico' => ['required', Rule::in(['dama', 'caballero', 'ninos', 'unisex'])],
            'tamano_esfera' => ['nullable', Rule::in(['pequeno', 'mediano', 'grande'])],
            'esta_activo' => ['sometimes', 'boolean'],
        ];
    }
}

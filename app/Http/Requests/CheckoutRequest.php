<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'nombre_destinatario' => ['required', 'string', 'max:150'],
            'telefono_destinatario' => ['required', 'string', 'max:25'],
            'direccion_envio' => ['required', 'string', 'max:255'],
            'ciudad_envio' => ['required', 'string', 'max:100'],
            'departamento_envio' => ['required', 'string', 'max:100'],
            'metodo_pago' => ['required', 'string', 'max:50'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_destinatario' => 'nombre del destinatario',
            'telefono_destinatario' => 'teléfono',
            'direccion_envio' => 'dirección',
            'ciudad_envio' => 'ciudad',
            'departamento_envio' => 'departamento',
            'metodo_pago' => 'método de pago',
        ];
    }
}
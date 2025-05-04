<?php

namespace App\Cart\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class AddCartItemRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'string',
                'size:26',
                'regex:/^[0-9A-Za-z]{26}$/'
            ],
            'variant_id' => [
                'nullable',
                'string',
                'size:26', 
                'regex:/^[0-9A-Za-z]{26}$/'
            ],
            'quantity' => 'required|integer|min:1',
            'price_at_time' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'El ID del producto es obligatorio.',
            'product_id.size' => 'El ID del producto debe tener exactamente 26 caracteres.',
            'product_id.regex' => 'El formato del ID del producto es inválido.',
            'variant_id.size' => 'El ID de la variante debe tener exactamente 26 caracteres.',
            'variant_id.regex' => 'El formato del ID de la variante es inválido.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad mínima es 1.',
            'price_at_time.required' => 'El precio es obligatorio.',
            'price_at_time.numeric' => 'El precio debe ser un número.',
            'price_at_time.min' => 'El precio no puede ser negativo.',
        ];
    }
}

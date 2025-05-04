<?php

namespace App\Cart\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class RemoveCartItemRequest extends BaseFormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'El ID del producto es obligatorio.',
            'product_id.size' => 'El ID del producto debe tener 26 caracteres.',
            'product_id.regex' => 'El formato del ID del producto no es válido.',
            'variant_id.size' => 'El ID de la variante debe tener 26 caracteres.',
            'variant_id.regex' => 'El formato del ID de la variante no es válido.',
        ];
    }
}

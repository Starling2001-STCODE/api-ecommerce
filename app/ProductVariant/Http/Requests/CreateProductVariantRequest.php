<?php

namespace App\ProductVariant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.sku' => ['required', 'string', 'max:100'],
            '*.price' => ['required', 'numeric', 'min:0'],
            '*.cost_price' => ['nullable', 'numeric', 'min:0'],
            '*.sale_price' => ['nullable', 'numeric', 'min:0'],
            '*.is_active' => ['boolean'],

            '*.quantity' => ['required', 'integer', 'min:0'],
            '*.minimum_stock' => ['nullable', 'integer', 'min:0'],

            '*.attribute_values' => ['required', 'array', 'min:1'],
            '*.attribute_values.*.attribute_id' => ['required', 'string'],
            '*.attribute_values.*.attribute_value_id' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            '*.sku.required' => 'Cada variante debe tener un SKU.',
            '*.price.required' => 'Cada variante debe tener un precio.',
            '*.stock.required' => 'Debes especificar la cantidad de stock.',
            '*.cost_price.numeric' => 'El costo debe ser un número.',
            '*.sale_price.numeric' => 'El precio de venta debe ser un número.',
            '*.is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
    
            '*.attribute_values.required' => 'Debes especificar los atributos de la variante.',
            '*.attribute_values.*.attribute_id.required' => 'Falta el ID del atributo.',
            '*.attribute_values.*.attribute_value_id.required' => 'Falta el valor del atributo.',
        ];
    }
    
}

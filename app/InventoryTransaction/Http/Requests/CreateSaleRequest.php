<?php

namespace App\InventoryTransaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        $validatedData['user_id'] = $this->user()->id;
        $validatedData['type'] = 'venta';

        return $validatedData;
    }

    public function rules(): array
    {
        return [
            'note' => ['nullable', 'string', 'max:255'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'string', 'exists:products,id'],
            'products.*.product_variant_id' => ['nullable', 'string', 'exists:product_variants,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'Debes agregar al menos un producto a la venta.',
            'products.*.product_id.required' => 'El ID del producto es obligatorio.',
            'products.*.product_id.exists' => 'El producto seleccionado no existe.',
            'products.*.quantity.required' => 'La cantidad es obligatoria.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
        ];
    }
}

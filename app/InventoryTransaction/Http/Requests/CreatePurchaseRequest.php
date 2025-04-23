<?php

namespace App\InventoryTransaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();
    
        $validatedData['user_id'] = $this->user()->id;
        $validatedData['type'] = 'compra';
    
        return $validatedData;
    }
    public function rules(): array
    {
        return [
            'ncf' => ['nullable', 'string', 'max:20'],
            'invoice_number' => ['nullable', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:255'],
            'products' => ['required', 'array', 'min:1'],

            'products.*.product_id' => ['required', 'string'],
            'products.*.product_variant_id' => ['nullable', 'string'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.cost_price' => ['nullable', 'numeric', 'min:0'],
            'products.*.sale_price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'Debes agregar al menos un producto a la transacción.',
            'products.*.product_id.required' => 'El ID del producto es obligatorio.',
            'products.*.product_id' => ['required', 'string', 'exists:products,id'],
            'products.*.quantity.required' => 'La cantidad es obligatoria.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
        ];
    }
}

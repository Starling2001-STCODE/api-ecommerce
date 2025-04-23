<?php

namespace App\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryProductSimpleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // o agrega lógica de autorización si es necesario
    }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
        ];
    }
}

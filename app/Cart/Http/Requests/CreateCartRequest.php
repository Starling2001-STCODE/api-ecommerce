<?php

namespace App\Cart\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class CreateCartRequest extends BaseFormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Puedes cambiar esto si necesitas controlar permisos
    }

    /**
     * Obtiene las reglas de validación para la solicitud.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1', // Asegura que "items" sea un array con al menos un elemento
            'items.*.product_id' => [
                'required',
                'string',
                'size:26', // Un ULID siempre tiene 26 caracteres
                'regex:/^[0-9A-Za-z]{26}$/', // Solo caracteres alfanuméricos
            ],
            'items.*.quantity' => 'required|integer|min:1', // La cantidad debe ser un entero positivo
            'items.*.price_at_time' => 'required|numeric|min:0', // El precio debe ser un número positivo
        ];
    }

    /**
     * Mensajes de error personalizados si los necesitas
     *
     * @return array
     */
    // public function messages(): array
    // {
    //     return [
    //         'product_id.required' => 'El producto es obligatorio.',
    //         'product_id.exists' => 'El producto seleccionado no existe.',
    //         'quantity.required' => 'La cantidad es obligatoria.',
    //         'quantity.integer' => 'La cantidad debe ser un número entero.',
    //         'quantity.min' => 'La cantidad debe ser al menos 1.',
    //         'price_at_time.required' => 'El precio es obligatorio.',
    //         'price_at_time.numeric' => 'El precio debe ser un número válido.',
    //         'price_at_time.min' => 'El precio debe ser mayor o igual a 0.',
    //     ];
    // }
    public function messages(): array
    {
        return [
            'items.required' => 'El campo "items" es obligatorio.',
            'items.array' => 'El campo "items" debe ser un array.',
            'items.min' => 'Debe haber al menos un producto en el carrito.',
            'items.*.product_id.required' => 'El ID del producto es obligatorio.',
            'items.*.product_id.string' => 'El ID del producto debe ser una cadena de texto.',
            'items.*.product_id.size' => 'El ID del producto debe tener exactamente 26 caracteres.',
            'items.*.product_id.exists' => 'El ID del producto debe tener exactamente 26 caracteres.',
            'items.*.product_id.regex' => 'El ID del producto tiene un formato inválido.',
            'items.*.quantity.required' => 'La cantidad es obligatoria.',
            'items.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'items.*.quantity.min' => 'La cantidad debe ser al menos 1.',
            'items.*.price_at_time.required' => 'El precio es obligatorio.',
            'items.*.price_at_time.numeric' => 'El precio debe ser un número.',
            'items.*.price_at_time.min' => 'El precio no puede ser negativo.',
        ];
    }
}

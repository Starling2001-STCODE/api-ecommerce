<?php

namespace App\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Puedes agregar lógica de autorización aquí si lo necesitas
    }
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();
        // Add user_id after validation
        $validatedData['user_id'] = $this->user()->id;

        return $validatedData;
    }

    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'cost_price'       => 'required|numeric|min:0',
            'sale_price'       => 'required|numeric|min:0|gte:cost_price',
            'brand'            => 'nullable|string|max:255',
            // 'weight'           => 'nullable|numeric|min:0',
            // 'dimensions'       => 'nullable|string|max:255',
            'status'           => 'required|in:active,inactive',
            'featured'         => 'boolean',
            'rating_average'   => 'nullable|numeric|min:0|max:5',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:50',

            'category_id'      => 'required|ulid|exists:categories,id',
            'size_id'          => 'required|ulid|exists:sizes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'El nombre del producto es obligatorio.',
            'name.string'             => 'El nombre del producto debe ser una cadena de texto.',
            'name.max'                => 'El nombre del producto no debe exceder los 255 caracteres.',
            'name.unique'             => 'Ya existe un producto con este nombre.',

            'description.string'      => 'La descripción debe ser una cadena de texto.',

            'cost_price.required'     => 'El precio de costo es obligatorio.',
            'cost_price.numeric'      => 'El precio de costo debe ser un número.',
            'cost_price.min'          => 'El precio de costo no puede ser negativo.',

            'sale_price.required'     => 'El precio de venta es obligatorio.',
            'sale_price.numeric'      => 'El precio de venta debe ser un número.',
            'sale_price.min'          => 'El precio de venta no puede ser negativo.',
            'sale_price.gte'          => 'El precio de venta debe ser mayor o igual al precio de costo.',

            // 'brand.string'            => 'La marca debe ser una cadena de texto.',
            // 'brand.max'               => 'La marca no debe exceder los 255 caracteres.',

            // 'weight.numeric'          => 'El peso debe ser un número.',
            // 'weight.min'              => 'El peso no puede ser negativo.',

            // 'dimensions.string'       => 'Las dimensiones deben ser una cadena de texto.',
            // 'dimensions.max'          => 'Las dimensiones no deben exceder los 255 caracteres.',

            'status.required'         => 'El estado del producto es obligatorio.',
            'status.in'               => 'El estado debe ser "active" o "inactive".',

            'featured.boolean'        => 'El campo "destacado" debe ser verdadero o falso.',

            'rating_average.numeric'  => 'La calificación promedio debe ser un número.',
            'rating_average.min'      => 'La calificación promedio no puede ser menor que 0.',
            'rating_average.max'      => 'La calificación promedio no puede ser mayor que 5.',

            'tags.array'              => 'Las etiquetas deben ser un arreglo.',
            'tags.*.string'           => 'Cada etiqueta debe ser una cadena de texto.',
            'tags.*.max'              => 'Cada etiqueta no debe exceder los 50 caracteres.',

            'category_id.required'    => 'La categoría es obligatoria.',
            'category_id.ulid'        => 'El ID de categoría no es válido.',
            'category_id.exists'      => 'La categoría seleccionada no existe.',

            'size_id.required'        => 'El tamaño es obligatorio.',
            'size_id.ulid'            => 'El ID de tamaño no es válido.',
            'size_id.exists'          => 'El tamaño seleccionado no existe.',

        ];
    }

}


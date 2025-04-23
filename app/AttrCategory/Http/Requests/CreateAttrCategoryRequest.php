<?php

namespace App\AttrCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttrCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',
            'required' => 'boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'category_id.required' => 'El campo categoría es obligatorio.',
            'category_id.exists'   => 'La categoría seleccionada no existe.',
            'attribute_id.required' => 'El campo atributo es obligatorio.',
            'attribute_id.exists'   => 'El atributo seleccionado no existe.',
            'required.boolean'      => 'El campo "requerido" debe ser verdadero o falso.',
        ];
    }
}

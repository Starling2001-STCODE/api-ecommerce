<?php

namespace App\AttributeValue\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class UpdateAttributeValueRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'attribute_id.required' => 'El campo attribute_id es obligatorio.',
            'attribute_id.exists' => 'El atributo especificado no existe.',
            'value.required' => 'El campo value es obligatorio.',
            'value.max' => 'El valor no debe exceder los 100 caracteres.',
        ];
    }
}
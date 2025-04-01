<?php

namespace App\Attribute\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class CreateAttributeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:attributes',
        ];
    }
}

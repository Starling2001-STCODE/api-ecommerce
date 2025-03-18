<?php
namespace App\Size\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class CreateSizeRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}

<?php

namespace App\Product\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class UpdateProductRequest extends BaseFormRequest
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
}

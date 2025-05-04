<?php

namespace App\ShippingAddress\Http\Requests;

use App\Core\Http\Requests\BaseFormRequest;

class CreateShippingAddressRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'street_address' => 'required|string|max:255',
            'house_number' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
            'line_address' => 'required|string|max:255',
        ];
    }
}

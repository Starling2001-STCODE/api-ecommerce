<?php

namespace App\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoogleLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_token' => ['required', 'string'],
        ];
    }
}
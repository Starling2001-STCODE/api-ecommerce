<?php

namespace App\VariantImage\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UploadVariantImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'images'   => 'required|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB por imagen
            'sku' => 'required|string|max:255', // necesario para renombrar las imágenes
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Debe subir al menos una imagen.',
            'images.*.image' => 'Cada archivo debe ser una imagen válida.',
            'images.*.mimes' => 'Las imágenes deben ser de tipo JPG, JPEG, PNG o WEBP.',
            'images.*.max' => 'Cada imagen no debe exceder los 2MB.',
            'sku.required' => 'El sku de la variante es obligatorio.',
        ];
    }
}

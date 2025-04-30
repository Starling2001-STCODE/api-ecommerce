<?php

namespace App\Category\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        // Normaliza a colección aunque venga como array
        $attributes = collect($this->attributes ?? []);

        return [
            'type' => 'categories',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'requires_variants' => $attributes->where('pivot.required', true)->isNotEmpty(),
                // 'attributes' => $attributes->map(function ($attribute) {
                //     return [
                //         'id' => $attribute['id'] ?? $attribute->id,
                //         'name' => $attribute['name'] ?? $attribute->name,
                //         'required' => $attribute['pivot']['required'] ?? $attribute->pivot->required ?? false,
                //     ];
                // })->values(),
            ],
        ];
    }
}

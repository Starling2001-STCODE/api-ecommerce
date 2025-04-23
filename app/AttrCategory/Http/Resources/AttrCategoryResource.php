<?php

namespace App\AttrCategory\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Attribute\Http\Resources\AttributeResource;
use App\Category\Http\Resources\CategoryResource;

class AttrCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'attrCategory',
            'id' => $this->id,
            'category_id' => $this->category_id,
            'attribute_id' => $this->attribute_id,
            'required' => (bool) $this->required,
            'createdAt' => $this->created_at instanceof \Carbon\Carbon
                ? $this->created_at->translatedFormat('d M Y H:i')
                : \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y H:i'),
            'updated_at' => $this->updated_at instanceof \Carbon\Carbon
                ? $this->updated_at->translatedFormat('d M Y H:i')
                : \Carbon\Carbon::parse($this->updated_at)->translatedFormat('d M Y H:i'),

            'relationships' => $this->when(
                $request->routeIs('attrCategory.show') || $request->routeIs('attrCategory.index'),
                fn () => (object) [
                    'attribute' => new AttributeResource($this->attribute),
                    'category' => new CategoryResource($this->category),
                ]
            ),
        ];
    }
}

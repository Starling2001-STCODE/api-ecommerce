<?php

namespace App\AttributeValue\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Attribute\Http\Resources\AttributeResource;

class AttributeValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'attributeValues',
            'id' => $this->id,
            'attributes' => [
                'attribute_id' => $this->attribute_id,
                'value' => $this->value,
                'createdAt' => $this->created_at instanceof \Carbon\Carbon
                ? $this->created_at->translatedFormat('d M Y H:i')
                : \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y H:i'),

            ],
            'relationships' => $this->when(
                $request->routeIs('attributeValues.show') || $request->routeIs('attributeValues.index'),
                fn () => (object)[
                    'attribute' => new AttributeResource((object) $this->attribute),
                ]
            ),
        ];
    }
}
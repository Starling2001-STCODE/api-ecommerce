<?php

namespace App\Product\Domain\Entities;

class Product
{
    public $id;
    public $name;
    public $description;
    public $cost_price;
    public $sale_price;
    public $brand;
    public $weight;
    public $dimensions;
    public $status;
    public $featured;
    public $rating_average;
    public $tags;
    public $user_id;
    public $category_id;
    public $size_id;
    public $created_at;
    public $updated_at;
    public $category;
    public $size;
    public $inventory;
    protected array $meta = [];
    public array $images = [];
    public array $variants = [];
    public $previewVariant = null;
    public $attributeValuePreviewImages = null;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->cost_price = $data['cost_price'] ?? null;
        $this->sale_price = $data['sale_price'] ?? null;
        $this->brand = $data['brand'] ?? null;
        $this->weight = $data['weight'] ?? null;
        $this->dimensions = $data['dimensions'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->featured = $data['featured'] ?? null;
        $this->rating_average = $data['rating_average'] ?? null;
        $this->tags = $data['tags'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->size_id = $data['size_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->category = $data['category'] ?? null;
        $this->size = $data['size'] ?? null;
        $this->images = $data['images'] ?? [];
        $this->variants = $data['variants'] ?? [];
        $this->previewVariant = $data['preview_variant'] ?? null;
        $this->attributeValuePreviewImages = $data['attributeValuePreviewImages'] ?? null;
        $this->inventory = $data['inventory'] ?? null;
        }
    public function setMeta(string $key, mixed $value): void
    {
        $this->meta[$key] = $value;
    }

    public function getMeta(string $key): mixed
    {
        return $this->meta[$key] ?? null;
    }

    public function getAllMeta(): array
    {
        return $this->meta;
    }
}


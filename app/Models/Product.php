<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'cost_price',
        'sale_price',
        'brand',
        'weight',
        'dimensions',
        'status',
        'featured',
        'rating_average',
        'tags',
        'category_id',
        'size_id',
        'user_id',
        'img',
    ];
    protected $casts = [
        'id' => 'string', 
        'cost_price' => 'decimal:2', 
        'sale_price' => 'decimal:2', 
        'weight' => 'decimal:2', 
        'rating_average' => 'decimal:2', 
        'featured' => 'boolean', 
        'tags' => 'array',
        'category_id' => 'string', 
        'size_id' => 'string',
        'user_id' => 'string',
        'status' => 'string', 
    ];
    public function user(){
        return $this->belongsTo(User::class); 
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function inventory()
    {
        return $this->hasOne(Inventory::class)
            ->whereNull('product_variant_id');
    }
    
    public function previewVariant()
    {
        return $this->hasOne(ProductVariant::class)->with('previewImages');
    }
    public function cart_detail(){
        return $this->hasMany(Cart_detail::class);
    }
    public function scopeName($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }
    public function scopeCategoryName($query, $search)
    {
        return $query->whereHas('category', function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
            Log::info($query->toSql());
        });
    }
    public function scopeSizeName($query, $search)
    {
        return $query->whereHas('size', function ($query) use ($search) {
            $query->where('name', 'like', "%$search%");
        });
    }
    public function scopeTagsAll($query, array $tags){
        return $query->whereRaw("tags @> ?", [json_encode($tags)]);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function limitedImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->limit(3);
    }
    public function attributeValuePreviewImages()
    {
        return $this->hasMany(AttributeValueImage::class)
                    ->limit(2);
    }
    
}

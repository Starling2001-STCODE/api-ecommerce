<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;


    class AttributeValue extends BaseModel
    {
        protected $table = 'attribute_values';

        protected $fillable = [
            'attribute_id',
            'value',
        ];

        public function attribute(): BelongsTo
        {
            return $this->belongsTo(Attribute::class);
        }
        public function productVariants(): BelongsToMany
        {
            return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_value')
                        ->withTimestamps();
        }
        public function images()
        {
            return $this->hasMany(AttributeValueImage::class);
        }
        public function imagesByProduct(string $productId)
        {
            return $this->hasMany(AttributeValueImage::class)
                        ->where('product_id', $productId);
        }
    }

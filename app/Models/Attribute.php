<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends BaseModel
{
    protected $table = 'attributes';

    protected $fillable = [
        'id',
        'name',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
        public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category', 'attribute_id', 'category_id')
                    ->withPivot('required')
                    ->withTimestamps();
    }

}

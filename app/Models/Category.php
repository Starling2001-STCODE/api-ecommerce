<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'parent_id',
    ];
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
        public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category', 'category_id', 'attribute_id')
                    ->withPivot('required')
                    ->withTimestamps();
    }
}

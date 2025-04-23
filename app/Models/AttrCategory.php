<?php


namespace App\Models;

class AttrCategory extends BaseModel 
{
    protected $table = 'attribute_category';

    protected $fillable = [
        'attribute_id',
        'category_id',
        'required',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends BaseModel
{
    protected $fillable = [
        'name',
    ];
    public function product(){
        return $this->hasMany(Product::class);
    }
}

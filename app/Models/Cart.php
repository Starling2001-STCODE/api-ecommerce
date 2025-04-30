<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends BaseModel
{
    protected $fillable = [
        'session_id',
        'status',
        'user_id',
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function cart_details(){
        return $this->hasMany(Cart_detail::class);
    }
}

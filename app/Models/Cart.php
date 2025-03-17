<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'status',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class); // (one to many)
    }
    public function Cart_detail(){
        return $this->hasMany(Cart_detail::class); // (one to many)
    }
}

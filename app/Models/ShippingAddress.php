<?php

namespace App\Models;


class ShippingAddress extends BaseModel
{
    protected $fillable = [
        'user_id',
        'street_address',
        'house_number',
        'additional_info',
        'city',
        'state',
        'postal_code',
        'country',
        'lat',
        'lng',
        'email',
        'phone',
        'line_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

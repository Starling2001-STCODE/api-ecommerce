<?php

namespace App\ShippingAddress\Domain\Entities;

class ShippingAddress
{
    public $id;
    public $user_id;
    public $street_address;
    public $house_number;
    public $additional_info;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $lat;
    public $lng;
    public $email;
    public $phone;
    public $line_address;
    public $created_at;
    public $updated_at;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->user_id = $data['user_id'];
        $this->street_address = $data['street_address'] ?? null;
        $this->house_number = $data['house_number'] ?? null;
        $this->additional_info = $data['additional_info'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->state = $data['state'] ?? null;
        $this->postal_code = $data['postal_code'] ?? null;
        $this->country = $data['country'] ?? null;
        $this->lat = $data['lat'] ?? null;
        $this->lng = $data['lng'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->line_address = $data['line_address'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }
}

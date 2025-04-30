<?php

namespace App\User\Domain\Entities;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $username;
    public $role;
    public $created_at;
    public $updated_at;
    public $phone;
    public $phone_verified_at;
    public $phone_verification_code;
    public $phone_verification_sent_at;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->username = $data['username'];
        $this->role = $data['role'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->phone_verified_at = $data['phone_verified_at'] ?? null;
        $this->phone_verification_code = $data['phone_verification_code'] ?? null;
        $this->phone_verification_sent_at = $data['phone_verification_sent_at'] ?? null;
    }
}

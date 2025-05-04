<?php

namespace App\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'user_profile',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'phone' => $this->phone,
                // 'avatar' => $this->avatar ? url('storage/' . $this->avatar) : null,
                'created_at' => $this->created_at,
            ],
        ];
    }
}

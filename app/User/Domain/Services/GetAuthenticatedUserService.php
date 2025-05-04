<?php

namespace App\User\Domain\Services;

use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserService
{
    public function execute()
    {
        return Auth::guard('sanctum')->user();
    }
}

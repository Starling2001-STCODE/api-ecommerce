<?php

namespace App\CartDetail\Domain\Contracts;

use App\CartDetail\Domain\Entities\CartDetail;
use Illuminate\Http\JsonResponse;



interface CartDetailRepositoryPort
{
        public function updateOrCreate(array $items): CartDetail;
}

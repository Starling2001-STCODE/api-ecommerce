<?php

namespace App\CartDetail\Domain\Contracts;

use App\CartDetail\Domain\Entities\CartDetail;
use Illuminate\Http\JsonResponse;

interface CartDetailRepositoryPort
{
        public function updateOrCreate(array $items): CartDetail;
        public function deleteSelectedItems(array $items, string $cartId): void;
        public function updateQuantityByProductAndVariant(string $cartId, string $productId, ?string $variantId, int $quantity): void;
        public function deleteByProductAndVariant(string $cartId, string $productId, ?string $variantId): void;
        public function addOrUpdateByProductAndVariant(string $cartId, array $itemData): void;
}

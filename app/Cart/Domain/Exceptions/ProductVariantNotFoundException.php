<?php

namespace App\Cart\Domain\Exceptions;

class ProductVariantNotFoundException extends InvalidCartItemException
{
    public function __construct(string $variantId)
    {
        parent::__construct("La variante con ID {$variantId} no fue encontrada o está inactiva.");
    }
}

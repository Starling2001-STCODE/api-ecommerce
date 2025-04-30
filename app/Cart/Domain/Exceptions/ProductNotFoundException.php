<?php

namespace App\Cart\Domain\Exceptions;

class ProductNotFoundException extends InvalidCartItemException
{
    public function __construct(string $productId)
    {
        parent::__construct("El producto con ID {$productId} no existe o no está disponible.");
    }
}

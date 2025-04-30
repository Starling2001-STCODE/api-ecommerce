<?php

namespace App\Cart\Domain\Exceptions;

class OutOfStockException extends InvalidCartItemException
{
    public function __construct(string $itemId, int $requested, int $available)
    {
        parent::__construct("Stock insuficiente para el item {$itemId}. Solicitado: {$requested}, Disponible: {$available}.");
    }
}

<?php

namespace App\Cart\Domain\Exceptions;

class PriceMismatchException extends InvalidCartItemException
{
    public function __construct(string $itemId, float $expected, float $received)
    {
        parent::__construct("Diferencia de precio en item {$itemId}. Esperado: {$expected}, Recibido: {$received}.");
    }
}

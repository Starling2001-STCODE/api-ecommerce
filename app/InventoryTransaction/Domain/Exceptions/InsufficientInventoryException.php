<?php

namespace App\InventoryTransaction\Domain\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InsufficientInventoryException extends HttpException
{
    public function __construct()
    {
        parent::__construct(403, "Insufficient inventory quantity.");
    }
}

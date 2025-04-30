<?php
namespace App\Cart\Domain\Exceptions;

use Exception;

class InvalidCartItemException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], 422);
    }
}

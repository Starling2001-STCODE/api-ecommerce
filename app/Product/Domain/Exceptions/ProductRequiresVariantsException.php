<?php

namespace App\Product\Domain\Exceptions;

use Exception;

class ProductRequiresVariantsException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage()
        ], 422);
    }
}

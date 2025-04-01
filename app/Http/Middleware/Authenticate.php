<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            abort(response()->json([
                'errors' => [
                    [
                        'status' => 401,
                        'message' => 'Unauthenticated.',
                        'source' => $request->path()
                    ]
                ]
            ], 401));
        }

        return null;
    }
}

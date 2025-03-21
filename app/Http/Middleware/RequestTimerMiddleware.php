<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RequestTimerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = round((microtime(true) - $start) * 1000, 2);

        Log::info('⏱️ Tiempo total del request [' . $request->method() . ' ' . $request->path() . ']: ' . $duration . ' ms');

        return $response;
    }
}

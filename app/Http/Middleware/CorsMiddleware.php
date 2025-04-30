<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $origin = $request->headers->get('Origin');

        $allowedOrigins = [
            'http://localhost:5173',   // ✅ importante
            'http://localhost:3000',   // (opcional por si abres otro frontend)
            'http://127.0.0.1:3000',   // (opcional)
        ];

        $headers = [
            'Access-Control-Allow-Origin' => in_array($origin, $allowedOrigins) ? $origin : '',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Guest-Session, Accept, Authorization, X-Requested-With, Origin',
            'Access-Control-Allow-Credentials' => 'true',
        ];

        // 🚨 Si es un preflight (OPTIONS), responder inmediato
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], Response::HTTP_NO_CONTENT, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            if (!empty($value)) {
                $response->headers->set($key, $value);
            }
        }

        return $response;
    }
}

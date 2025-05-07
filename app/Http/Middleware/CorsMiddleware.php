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
            'http://localhost:5173',  
            'http://localhost:3000',
            'http://127.0.0.1:3000',
            'http://bodyfitt.s3-website-us-east-1.amazonaws.com',  
        ];

        $headers = [
            'Access-Control-Allow-Origin' => in_array($origin, $allowedOrigins) ? $origin : '',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Guest-Session, Accept, Authorization, X-Requested-With, Origin',
            'Access-Control-Allow-Credentials' => 'true',
        ];

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

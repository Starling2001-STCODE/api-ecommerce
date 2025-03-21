<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;


class GuestSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
            // Rate limiting basado en IP: 100 peticiones por minuto
        // $ip = $request->ip();
        // $key = 'guest_session_rate:' . $ip;
        // $maxAttempts = 100;
        // $decaySeconds = 60;

        // if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
        //     return response()->json(
        //         ['message' => 'Demasiadas peticiones. Inténtalo más tarde.'],
        //         429
        //     );
        // }
        // RateLimiter::hit($key, $decaySeconds);
        if (!Auth::guard('sanctum')->check()) {
            $encryptedCookie = $request->cookie('guest_session');
            $guestSession = null;

            if ($encryptedCookie) {
                try {
                    $guestSession = Crypt::decryptString($encryptedCookie);
                    if (!Str::isUuid($guestSession)) {
                        $guestSession = null;
                    } else {
                        $request->attributes->set('guest_session', $guestSession);
                    }
                } catch (\Exception $e) {
                    $guestSession = null;
                }
            }
            if (!$guestSession) {
                $newSession = Str::uuid()->toString();
                $request->attributes->set('guest_session_new', $newSession);
            }
        }

        $response = $next($request);

        if ($request->attributes->has('guest_session_new')) {
            $newSession = $request->attributes->get('guest_session_new');
            $encryptedValue = Crypt::encryptString($newSession);

            $response->headers->setCookie(cookie(
                'guest_session',
                $encryptedValue,
                60 * 24 * 30,  // 30 días
                null,          // path
                null,          // domain
                false,         // secure (true en producción HTTPS)
                true,         // httpOnly
                true,          // raw
                false          // SameSite
            ));
        }
        return $response;
    }
}

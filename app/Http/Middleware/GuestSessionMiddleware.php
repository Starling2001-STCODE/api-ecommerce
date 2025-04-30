<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GuestSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Solo crear/cargar guest_session si no está autenticado
        if (!Auth::guard('sanctum')->check()) {
            $guestSession = null;
            $encryptedCookie = $request->cookie('guest_session');

            if ($encryptedCookie) {
                try {
                    $decrypted = Crypt::decryptString($encryptedCookie);
                    if (Str::isUuid($decrypted)) {
                        $guestSession = $decrypted;
                        $request->attributes->set('guest_session', $guestSession);
                    }
                } catch (\Exception $e) {
                    Log::warning('Falló desencriptar la guest_session cookie.', ['error' => $e->getMessage()]);
                }
            }

            if (!$guestSession) {
                $newSession = Str::uuid()->toString();
                $request->attributes->set('guest_session_new', $newSession);
            }
        }

        $response = $next($request);

        // Si se generó una nueva sesión, la escribimos en cookie
        if ($request->attributes->has('guest_session_new')) {
            $newSession = $request->attributes->get('guest_session_new');
            $encryptedValue = Crypt::encryptString($newSession);

            $response->headers->setCookie(cookie(
                'guest_session',            // Nombre de la cookie
                $encryptedValue,             // Valor cifrado
                60 * 24 * 30,                // Duración: 30 días
                '/',                         // Path
                null,                        // Dominio: actual
                app()->environment('production'), // Secure true solo en producción
                true,                        // HttpOnly
                false,                       // Raw
                'Lax'                       // SameSite: None (permite cross-site)
            ));
        }

        return $response;
    }
}

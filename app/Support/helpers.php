<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


if (!function_exists('guest_session')) {
    function guest_session(): ?string
    {
        $encrypted = Cookie::get('guest_session');

        try {
            $decrypted = Crypt::decryptString($encrypted);
            return Str::isUuid($decrypted) ? $decrypted : null;
        } catch (\Exception $e) {
            Log::warning('guest_session inválido: ' . $e->getMessage());
            return null;
        }
    }
}

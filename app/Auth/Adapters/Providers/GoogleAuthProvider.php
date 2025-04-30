<?php
namespace App\Auth\Adapters\Providers;

use App\Auth\Domain\Contracts\GoogleAuthProviderPort;
use Illuminate\Support\Facades\Http;

class GoogleAuthProvider implements GoogleAuthProviderPort
{
    public function validateToken(string $idToken): array
    {
        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if (!$response->ok()) {
            throw new \Exception('Token inválido o expirado.');
        }

        $data = $response->json();

        if (!isset($data['email'])) {
            throw new \Exception('Token válido, pero no contiene email.');
        }

        if (isset($data['email_verified']) && $data['email_verified'] != 'true') {
            throw new \Exception('El correo electrónico no está verificado.');
        }

        return [
            'email' => $data['email'],
            'name' => $data['name'] ?? '',
            'picture' => $data['picture'] ?? null,
            'email_verified' => $data['email_verified'] ?? false,   
            'google_id' => $data['sub'],
        ];
    }
}

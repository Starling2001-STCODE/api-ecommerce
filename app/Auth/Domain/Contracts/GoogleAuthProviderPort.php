<?php

namespace App\Auth\Domain\Contracts;

interface GoogleAuthProviderPort
{
    public function validateToken(string $idToken): array;
}

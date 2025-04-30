<?php

namespace App\Auth\Domain\Services;

use App\Auth\Domain\Contracts\AuthRepositoryPort;
use App\Auth\Domain\Contracts\GoogleAuthProviderPort;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class LoginWithGoogleService
{
    private AuthRepositoryPort $authRepository;
    private GoogleAuthProviderPort $googleAuthProvider;

    public function __construct(AuthRepositoryPort $authRepository, GoogleAuthProviderPort $googleAuthProvider)
    {
        $this->authRepository = $authRepository;
        $this->googleAuthProvider = $googleAuthProvider;
    }

    public function execute(string $idToken): array
    {
        $googleUserData = $this->googleAuthProvider->validateToken($idToken);
        if (!isset($googleUserData['email_verified']) || $googleUserData['email_verified'] !== 'true') {
            throw new Exception('Tu cuenta de Google no tiene email verificado.');
        }
        $loginData = $this->authRepository->loginByEmail($googleUserData['email']);
        if (!$loginData) {
            $newUser = $this->authRepository->createUserFromGoogle($googleUserData);
            $loginData = $this->authRepository->loginByEmail($newUser->email);
        }
        return $loginData;
    }
}

<?php

namespace App\Auth\Domain\Contracts;

use App\Auth\Domain\Entities\User;
use App\Models\User as UserModel;


interface AuthRepositoryPort
{
    public function login(User $user): array |null;
    public function logout(): void;
    public function me(): array |null;
    public function loginByEmail(string $email): array | null;
    public function createUserFromGoogle(array $googleUserData): UserModel;
    public function resetPassword(string $token, string $newPassword): void;
    public function sendResetPasswordEmail(string $email): void;
}

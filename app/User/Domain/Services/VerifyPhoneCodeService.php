<?php

namespace App\User\Domain\Services;

use App\User\Domain\Contracts\UserRepositoryPort;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VerifyPhoneCodeService
{
    private UserRepositoryPort $userRepository;

    public function __construct(UserRepositoryPort $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $userId, string $code): void
    {
        DB::transaction(function () use ($userId, $code) {
            $user = $this->userRepository->findById($userId);

            if ($user->phone_verification_code !== $code) {
                throw ValidationException::withMessages([
                    'code' => 'Código de verificación incorrecto.',
                ]);
            }

            $this->userRepository->update($user->id, [
                'phone_verified_at' => now(),
                'phone_verification_code' => null,
                'phone_verification_sent_at' => null,
            ]);
        });
    }
}

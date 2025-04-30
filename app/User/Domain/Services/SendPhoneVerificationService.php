<?php

namespace App\User\Domain\Services;

use App\User\Domain\Contracts\UserRepositoryPort;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendPhoneVerificationService
{
    private UserRepositoryPort $userRepository;

    public function __construct(UserRepositoryPort $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $userId): void
    {
        DB::transaction(function () use ($userId) {
            $user = $this->userRepository->findById($userId);

            // Generar un código de 6 dígitos aleatorio
            $code = random_int(100000, 999999);

            $this->userRepository->update($user->id, [
                'phone_verification_code' => $code,
                'phone_verification_sent_at' => now(),
            ]);

            // Aquí deberías integrar un servicio de SMS real (Twilio, etc.)
            Log::info("Código SMS enviado al teléfono {$user->phone}: {$code}");
        });
    }
}

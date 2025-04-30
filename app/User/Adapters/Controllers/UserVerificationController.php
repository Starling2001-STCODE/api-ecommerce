<?php

namespace App\User\Adapters\Controllers;

use App\User\Domain\Services\SendPhoneVerificationService;
use App\User\Domain\Services\VerifyPhoneCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserVerificationController
{
    private SendPhoneVerificationService $sendPhoneVerificationService;
    private VerifyPhoneCodeService $verifyPhoneCodeService;

    public function __construct(
        SendPhoneVerificationService $sendPhoneVerificationService,
        VerifyPhoneCodeService $verifyPhoneCodeService,
    ) {
        $this->sendPhoneVerificationService = $sendPhoneVerificationService;
        $this->verifyPhoneCodeService = $verifyPhoneCodeService;
    }

    public function sendPhoneVerification()
    {
        $userId = Auth::guard('sanctum')->id();
        $this->sendPhoneVerificationService->execute($userId);

        return response()->json(['message' => 'Código de verificación enviado por SMS']);
    }

    public function verifyPhoneCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|min:6|max:6',
        ]);

        $userId = Auth::guard('sanctum')->id();
        $this->verifyPhoneCodeService->execute($userId, $request->input('code'));

        return response()->json(['message' => 'Teléfono verificado correctamente']);
    }


    public function verifyEmail($id, $hash)
    {
        $user = \App\Models\User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Enlace de verificación inválido.');
        }

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        return response()->json(['message' => 'Correo electrónico verificado correctamente']);
    }
}

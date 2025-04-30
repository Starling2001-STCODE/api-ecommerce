<?php

namespace App\User\Domain\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\User\Adapters\Mail\VerifyEmailCustom;
use App\Models\User as EloquentUser;

class SendEmailVerificationService
{
    public function executeFor(EloquentUser $user): void
    {
        if ($user->hasVerifiedEmail()) {
            return;
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        Mail::to($user->email)->send(new VerifyEmailCustom($verificationUrl));
    }

}

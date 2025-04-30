<?php

namespace App\User\Adapters\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailCustom extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;

    public function __construct(string $verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->subject('Verifica tu correo electrónico')
                    ->markdown('emails.verify-email');
    }
}
// Compare this snippet from resources/views/emails/verify-email.blade.php:
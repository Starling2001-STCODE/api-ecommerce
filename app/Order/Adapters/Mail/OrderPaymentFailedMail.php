<?php

namespace App\Order\Adapters\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order\Domain\Entities\Order;

class OrderPaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Problemas con tu pago')
                    ->markdown('emails.orders.payment_failed');
    }
}

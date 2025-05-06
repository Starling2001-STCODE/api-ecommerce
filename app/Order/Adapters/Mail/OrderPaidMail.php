<?php

namespace App\Order\Adapters\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order\Domain\Entities\Order;

class OrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('¡Pago confirmado!')
                    ->markdown('emails.orders.paid');
    }
}

<?php

namespace App\Order\Domain\Services;

use App\Order\Domain\Entities\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Order\Adapters\Mail\OrderCreatedMail;
use App\Order\Adapters\Mail\OrderPaidMail;
use App\Order\Adapters\Mail\OrderExpiredMail;
use App\Order\Adapters\Mail\OrderPaymentFailedMail;

class SendOrderEmailService
{
    public function sendOrderCreated(Order $order): void
    {
        $user = $this->getUserFromOrder($order);
        if ($user) {
            Mail::to($user->email)->send(new OrderCreatedMail($order));
        }
    }

    public function sendOrderPaid(Order $order): void
    {
        $user = $this->getUserFromOrder($order);
        if ($user) {
            Mail::to($user->email)->send(new OrderPaidMail($order));
        }
    }

    public function sendOrderExpired(Order $order): void
    {
        $user = $this->getUserFromOrder($order);
        if ($user) {
            Mail::to($user->email)->send(new OrderExpiredMail($order));
        }
    }

    public function sendOrderPaymentFailed(Order $order): void
    {
        $user = $this->getUserFromOrder($order);
        if ($user) {
            Mail::to($user->email)->send(new OrderPaymentFailedMail($order));
        }
    }

    private function getUserFromOrder(Order $order): ?User
    {
        if (!$order->user_id) {
            return null;
        }
        return User::find($order->user_id);
    }
}

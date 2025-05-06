<?php

namespace App\StripeCheckout\Domain\Services;

use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\InventoryTransaction\Domain\Services\CreateSaleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Order\Adapters\Mail\OrderPaidMail;
use App\Order\Adapters\Mail\OrderExpiredMail;
use App\Order\Adapters\Mail\OrderPaymentFailedMail;
use App\Models\User;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class HandleStripeWebhookService
{
    private OrderRepositoryPort $orderRepository;
    private CreateSaleService $createSaleService;

    public function __construct(
        OrderRepositoryPort $orderRepository,
        CreateSaleService $createSaleService
    ) {
        $this->orderRepository = $orderRepository;
        $this->createSaleService = $createSaleService;
    }

    public function execute(string $payload): void
    {
        $endpointSecret = config('services.stripe.webhook_secret');
        $sigHeader = request()->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            abort(400, 'Invalid signature');
        }

        switch ($event->type) {
            case 'checkout.session.completed':
            case 'checkout.session.async_payment_succeeded':
                $this->handleSuccessfulPayment($event->data->object);
                break;

            case 'checkout.session.expired':
                $this->handleExpiredSession($event->data->object);
                break;

            case 'checkout.session.async_payment_failed':
                $this->handleFailedPayment($event->data->object);
                break;

            default:
        }
    }

    private function handleSuccessfulPayment($session): void
    {
        DB::beginTransaction();

        try {

            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                abort(400, 'Order not found');
            }

            if ($order->status === 'paid') {
                DB::commit();
                return;
            }

            if (isset($session->payment_status) && $session->payment_status !== 'paid') {
                DB::commit();
                return;
            }

            $this->orderRepository->update($order->id, [
                'status' => 'paid',
            ]);

            $saleData = [
                'note' => 'Venta de productos vía Checkout',
                'user_id' => $order->user_id ?? null,
                'type' => 'venta',
                'products' => array_map(function ($item) {
                    return [
                        'product_id' => $item['product_id'],
                        'product_variant_id' => $item['variant_id'] ?? null,
                        'quantity' => $item['quantity'],
                    ];
                }, $order->items),
            ];

            $this->createSaleService->execute($saleData);

            $user = User::find($order->user_id);
            if ($user) {
                Mail::to($user->email)->send(new OrderPaidMail($order));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling successful payment.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function handleExpiredSession($session): void
    {
        DB::beginTransaction();

        try {
            Log::info('Handling expired session.', ['session_id' => $session->id]);

            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                abort(400, 'Order not found');
            }

            if ($order->status !== 'paid') {
                $this->orderRepository->update($order->id, [
                    'status' => 'cancelled',
                ]);

                Log::info('Order marked as cancelled.', ['order_id' => $order->id]);

                $user = User::find($order->user_id);
                if ($user) {
                    Mail::to($user->email)->send(new OrderExpiredMail($order));
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling expired session.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function handleFailedPayment($session): void
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                abort(400, 'Order not found');
            }

            if ($order->status !== 'paid') {
                $this->orderRepository->update($order->id, [
                    'status' => 'pending_payment',
                ]);


                $user = User::find($order->user_id);
                if ($user) {
                    Mail::to($user->email)->send(new OrderPaymentFailedMail($order));
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling failed payment.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}

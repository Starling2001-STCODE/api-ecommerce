<?php

namespace App\StripeCheckout\Domain\Services;

use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\InventoryTransaction\Domain\Services\CreateSaleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            Log::error('Invalid Stripe Webhook signature.', ['error' => $e->getMessage()]);
            abort(400, 'Invalid signature');
        }

        Log::info('Stripe Webhook Event Received:', ['type' => $event->type]);

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
                Log::info('Unhandled Stripe Webhook Event Type', ['type' => $event->type]);
        }
    }

    private function handleSuccessfulPayment($session): void
    {
        DB::beginTransaction();

        try {
            Log::info('Handling successful payment for session.', ['session_id' => $session->id]);

            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                Log::error('Order not found for session_id.', ['session_id' => $session->id]);
                abort(400, 'Order not found');
            }

            // Doble validación: no actualizar si ya está pagada
            if ($order->status === 'paid') {
                Log::info('Order already marked as paid.', ['order_id' => $order->id]);
                DB::commit();
                return;
            }

            // Validar también el payment_status que envía Stripe
            if (isset($session->payment_status) && $session->payment_status !== 'paid') {
                Log::warning('Payment not completed yet.', [
                    'order_id' => $order->id,
                    'payment_status' => $session->payment_status,
                ]);
                DB::commit();
                return;
            }

            $this->orderRepository->update($order->id, [
                'status' => 'paid',
            ]);
            Log::info('Order marked as paid.', ['order_id' => $order->id]);

            // Formar estructura de productos para CreateSaleService
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

            Log::info('Sale data prepared for CreateSaleService.', ['saleData' => $saleData]);

            $this->createSaleService->execute($saleData);

            Log::info('Sale transaction created successfully.', ['order_id' => $order->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling successful payment.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function handleExpiredSession($session): void
    {
        try {
            Log::info('Handling expired session.', ['session_id' => $session->id]);

            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                Log::error('Order not found for session_id.', ['session_id' => $session->id]);
                abort(400, 'Order not found');
            }

            if ($order->status !== 'paid') {
                $this->orderRepository->update($order->id, [
                    'status' => 'cancelled',
                ]);

                Log::info('Order marked as cancelled.', ['order_id' => $order->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling expired session.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function handleFailedPayment($session): void
    {
        try {
            Log::info('Handling failed payment.', ['session_id' => $session->id]);

            $order = $this->orderRepository->findBySessionId($session->id);

            if (!$order) {
                Log::error('Order not found for session_id.', ['session_id' => $session->id]);
                abort(400, 'Order not found');
            }

            if ($order->status !== 'paid') {
                $this->orderRepository->update($order->id, [
                    'status' => 'pending_payment',
                ]);

                Log::warning('Order payment failed, status updated to pending_payment.', ['order_id' => $order->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling failed payment.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}

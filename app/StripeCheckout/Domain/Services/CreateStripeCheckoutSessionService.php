<?php

namespace App\StripeCheckout\Domain\Services;

use App\Cart\Domain\Services\EnrichCartItemsService;
use App\Cart\Domain\Services\ValidateCartItemsService;
use App\StripeCheckout\Domain\Services\PrepareStripeLineItemsService;
use App\Order\Domain\Services\CreateOrderFromCartService;
use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Order\Domain\Services\SendOrderEmailService;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class CreateStripeCheckoutSessionService
{
    private EnrichCartItemsService $enrichCartItemsService;
    private ValidateCartItemsService $validateCartItemsService;
    private PrepareStripeLineItemsService $prepareStripeLineItemsService;
    private CreateOrderFromCartService $createOrderFromCartService;
    private OrderRepositoryPort $orderRepository;
    private SendOrderEmailService $sendOrderEmailService;

    public function __construct(
        EnrichCartItemsService $enrichCartItemsService,
        ValidateCartItemsService $validateCartItemsService,
        PrepareStripeLineItemsService $prepareStripeLineItemsService,
        CreateOrderFromCartService $createOrderFromCartService,
        OrderRepositoryPort $orderRepository,
        SendOrderEmailService $sendOrderEmailService
    ) {
        $this->enrichCartItemsService = $enrichCartItemsService;
        $this->validateCartItemsService = $validateCartItemsService;
        $this->prepareStripeLineItemsService = $prepareStripeLineItemsService;
        $this->createOrderFromCartService = $createOrderFromCartService;
        $this->orderRepository = $orderRepository;
        $this->sendOrderEmailService = $sendOrderEmailService;
    }

    public function execute(array $rawCartItems): string
    {
        $baseUrl = config('app.url');
        
        $enrichedItems = $this->enrichCartItemsService->execute($rawCartItems);
        $validatedItems = $this->validateCartItemsService->execute($enrichedItems);
        $order = $this->createOrderFromCartService->execute($validatedItems);
        $lineItems = $this->prepareStripeLineItemsService->execute($validatedItems);

        Stripe::setApiKey(Config::get('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card', 'klarna', 'sepa_debit'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $baseUrl . '/checkout/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $baseUrl . '/checkout/cancel',
            'expires_at' => time() + 1800,
        ]);

        $this->orderRepository->update($order->id, [
            'session_id' => $session->id,
            'checkout_url' => $session->url,
            'expires_at' => Date::parse($session->expires_at)->toDateTimeString(),
        ]);

        $order->checkout_url = $session->url;
        $order->expires_at = Date::parse($session->expires_at)->toDateTimeString();
        $this->sendOrderEmailService->sendOrderCreated($order);
        return $session->url;
    }
}

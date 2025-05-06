@component('mail::message')
# ¡Gracias por tu orden!

Hemos creado tu orden #{{ $order->display_order_id }}.

**Total**: ${{ number_format($order->total, 2) }}

@component('mail::button', ['url' => $order->checkout_url])
Completar Pago
@endcomponent

Este enlace expira el {{ \Carbon\Carbon::parse($order->expires_at)->diffForHumans() }}.

¡Gracias por confiar en nosotros!

{{ config('app.name') }}
@endcomponent
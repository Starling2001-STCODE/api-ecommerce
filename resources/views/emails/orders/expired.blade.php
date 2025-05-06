@component('mail::message')
# Orden expirada

Tu orden #{{ $order->display_order_id }} ha expirado porque no se completó el pago a tiempo.

**Total pendiente**: ${{ number_format($order->total, 2) }} USD

Si todavía deseas comprar, por favor vuelve a realizar tu pedido.

Gracias por tu comprensión.

{{ config('app.name') }}
@endcomponent
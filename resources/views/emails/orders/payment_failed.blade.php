@component('mail::message')
# Error en el pago

Hubo un problema al intentar procesar el pago de tu orden #{{ $order->display_order_id }}.

**Total**: ${{ number_format($order->total, 2) }} USD

Por favor intenta nuevamente desde tu cuenta para completar el pago.

¡Estamos aquí para ayudarte!

{{ config('app.name') }}
@endcomponent
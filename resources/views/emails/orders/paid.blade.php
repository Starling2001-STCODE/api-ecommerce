@component('mail::message')
# ¡Pago recibido!

Tu orden #{{ $order->display_order_id }} ha sido pagada exitosamente.

**Total pagado**: ${{ number_format($order->total, 2) }} USD

Nos pondremos en contacto pronto para los detalles de tu envío.

¡Gracias por confiar en nosotros!

{{ config('app.name') }}
@endcomponent
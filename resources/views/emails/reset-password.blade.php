@component('mail::message')
# Recupera el acceso a tu cuenta

Hola {{ $userName }},

Recibimos una solicitud para cambiar tu contraseña en **{{ config('app.name') }}**.

@component('mail::button', ['url' => $resetUrl])
Crear nueva contraseña
@endcomponent

Si no realizaste esta solicitud, puedes ignorar este mensaje.

Saludos,
**{{ config('app.name') }}**

@slot('footer')
© {{ now()->year }} {{ config('app.name') }}. Todos los derechos reservados.
@endslot

@endcomponent
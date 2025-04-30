@component('mail::message')
# ¡Bienvenido a DomiClick!

Haz clic en el botón para verificar tu correo electrónico y comenzar a disfrutar de nuestros servicios.

@component('mail::button', ['url' => $verificationUrl])
Verificar correo
@endcomponent

Si no creaste una cuenta, puedes ignorar este mensaje.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
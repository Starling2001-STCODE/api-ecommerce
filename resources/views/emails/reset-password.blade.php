@component('mail::message')
# Restablece tu contraseña

Haz clic en el botón para establecer una nueva contraseña:

@component('mail::button', ['url' => $resetUrl])
Restablecer contraseña
@endcomponent

Si no solicitaste esto, puedes ignorarlo.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
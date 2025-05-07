@component('mail::layout')

{{-- Encabezado --}}
# ¿Olvidaste tu contraseña?

Hola,

Recibimos una solicitud para restablecer tu contraseña.
Haz clic en el siguiente botón para crear una nueva contraseña:

{{-- Botón de acción --}}
@component('mail::button', ['url' => $resetUrl])
Cambiar Contraseña
@endcomponent

---

**¿No hiciste esta solicitud?**
No te preocupes, simplemente ignora este correo y no se realizarán cambios.

Gracias por confiar en nosotros.
**El equipo de {{ config('app.name') }}**

@endcomponent
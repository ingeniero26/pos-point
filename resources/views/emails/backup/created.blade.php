@component('mail::message')
# Notificación de Backup

Se ha creado un nuevo backup de la aplicación.

Detalles del backup:
- Fecha: {{ now()->format('Y-m-d H:i:s') }}
- Estado: Éxito

Gracias,
{{ config('app.name') }}
@endcomponent

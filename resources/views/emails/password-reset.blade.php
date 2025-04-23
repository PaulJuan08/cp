@component('mail::message')
# Password Reset Notification

Hello {{ $userName }},

Your password has been reset by an administrator. Here's your new temporary password:

**Temporary Password:** <code>{{ $newPassword }}</code>

Please log in using this password and change it immediately for security reasons.

Best regards,<br>
{{ config('app.name') }}

If you didn't request this change, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
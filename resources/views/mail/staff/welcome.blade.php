<x-mail::message>
# Welcome to HWMS, {{ $staffName }}!

Your hospital staff account has been created by the Administrator. Below are your login credentials:

<x-mail::panel>
**Email:** {{ $staffEmail }}

**Temporary Password:** `{{ $tempPassword }}`
</x-mail::panel>

> **Important:** For security purposes, you will be required to **change your password** immediately after your first login.

<x-mail::button :url="$loginUrl" color="success">
Login to Staff Portal
</x-mail::button>

You will also receive a separate email to verify your address. Please verify it before accessing your dashboard.

Thanks,<br>
{{ config('app.name') }} Administration
</x-mail::message>


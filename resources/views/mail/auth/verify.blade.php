<x-mail::message>
# Welcome to HWMS, {{ $name }}!
 
Your account has been successfully registered. To fully activate your access to the Hospital Washroom Management System (HWMS) portals, please verify your email address.
 
<x-mail::button :url="$url" color="success">
Verify Account
</x-mail::button>

<x-mail::panel>
If you did not request this account, no further action is required. Your unregistered data will be discarded.
</x-mail::panel>
 
Thanks,<br>
{{ config('app.name') }} Security
</x-mail::message>


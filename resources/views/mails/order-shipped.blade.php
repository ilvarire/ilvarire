@component('mail::message')
# Order Shipped

We're excited to inform you that your order has been shipped!.<br>
Your can expect to receive it within 7 - 12 working days.
Thanks for shopping with us, and we hope you enjoy your purchase!

@component('mail::button', ['url' => $url])
See details
@endcomponent

Best regards, <br>
{{ config('app.name') }}
@endcomponent
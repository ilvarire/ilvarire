@component('mail::message')
# Payment Successful

Your payment {{number_format($total_price, 2)}} for order {{$reference}} has been completed and your order is now being
processed.

@component('mail::button', ['url' => $url])
See details
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent
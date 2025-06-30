@component('mail::message')
# New Order Created

hello admin,<br>
payment of {{number_format($total_price, 2)}} for new order {{$reference}} has been completed.

@component('mail::button', ['url' => $url])
See details
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent
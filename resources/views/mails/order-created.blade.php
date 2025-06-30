@component('mail::message')
# Order Created

Your order {{$reference}} has been created and payment is pending.

@component('mail::button', ['url' => $url])
See details
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent
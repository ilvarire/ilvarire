@component('mail::message')
# Order Delivered

Your order {{$reference}} has been marked as delivered.
You can now rate the products you have received to help us improve our services.<br>
Thank you for choosing us, and we appreciate your patronage. We look forward to serving you again!
<br><br>

Thanks, <br>
{{ config('app.name') }}
@endcomponent
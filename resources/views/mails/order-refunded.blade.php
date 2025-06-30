@component('mail::message')
# Order Refunded

Your order {{$reference}} was cancelled and we are pleased to inform you that a refund for your order has been
processed. The amount will be
credited back to your original payment method. <br>
Thank you for your patience, and we apologize for any inconvenience caused. if you have any further
questions, please don't hesitate to reach out.

Best regards, <br>
{{ config('app.name') }}
@endcomponent
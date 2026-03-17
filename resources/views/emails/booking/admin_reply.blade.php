@php($routeName = optional(optional($booking->departure)->trekkingRoute)->name)
@php($departureDate = optional(optional($booking->departure)->departure_date)?->toDateString())

<p>Hi {{ $booking->customer_name }},</p>

{!! nl2br(e($messageBody)) !!}

<hr>
<p style="font-size: 12px; color: #666;">
Reference: {{ $booking->booking_ref }}
@if($routeName) | Route: {{ $routeName }}@endif
@if($departureDate) | Departure: {{ $departureDate }}@endif
</p>

<p>Kind regards,<br>{{ config('app.name') }}</p>


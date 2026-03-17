@php($routeName = optional(optional($booking->departure)->trekkingRoute)->name)
@php($departureDate = optional(optional($booking->departure)->departure_date)?->toDateString())

<p>Hi {{ $booking->customer_name }},</p>

<p>
Thank you for your booking request. Our team will contact you shortly to confirm details and arrange payment.
</p>

<p><strong>Request details</strong></p>
<ul>
    @if($routeName)
        <li><strong>Route:</strong> {{ $routeName }}</li>
    @endif
    @if($departureDate)
        <li><strong>Departure date:</strong> {{ $departureDate }}</li>
    @endif
    <li><strong>Group size:</strong> {{ $booking->group_size }}</li>
    @if($booking->country)
        <li><strong>Country:</strong> {{ $booking->country }}</li>
    @elseif($booking->nationality)
        <li><strong>Country:</strong> {{ $booking->nationality }}</li>
    @endif
    <li><strong>Reference:</strong> {{ $booking->booking_ref }}</li>
</ul>

@if($booking->special_requests)
    <p><strong>Special requests</strong></p>
    <p>{{ $booking->special_requests }}</p>
@endif

<p>Kind regards,<br>{{ config('app.name') }}</p>


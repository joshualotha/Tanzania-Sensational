@php($routeName = optional(optional($booking->departure)->trekkingRoute)->name)
@php($departureDate = optional(optional($booking->departure)->departure_date)?->toDateString())

<p>A new booking request was submitted.</p>

<p><strong>Customer</strong></p>
<ul>
    <li><strong>Name:</strong> {{ $booking->customer_name }}</li>
    <li><strong>Email:</strong> {{ $booking->email }}</li>
    @if($booking->phone)
        <li><strong>Phone:</strong> {{ $booking->phone }}</li>
    @endif
    @if($booking->country)
        <li><strong>Country:</strong> {{ $booking->country }}</li>
    @elseif($booking->nationality)
        <li><strong>Country:</strong> {{ $booking->nationality }}</li>
    @endif
</ul>

<p><strong>Booking</strong></p>
<ul>
    @if($routeName)
        <li><strong>Route:</strong> {{ $routeName }}</li>
    @endif
    @if($departureDate)
        <li><strong>Departure date:</strong> {{ $departureDate }}</li>
    @endif
    <li><strong>Group size:</strong> {{ $booking->group_size }}</li>
    <li><strong>Status:</strong> {{ strtoupper($booking->status) }}</li>
    <li><strong>Reference:</strong> {{ $booking->booking_ref }}</li>
</ul>

@if($booking->special_requests)
    <p><strong>Special requests</strong></p>
    <p>{{ $booking->special_requests }}</p>
@endif

<p>
Open the dashboard to manage this request: <a href="{{ $adminUrl }}">{{ $adminUrl }}</a>
</p>


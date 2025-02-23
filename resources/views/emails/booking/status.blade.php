@component('mail::message')
# Booking Status Update

Dear {{ $booking->name }},

Your booking request for **{{ $booking->booking_date->format('d M, Y H:i:s') }}** at **{{ $booking->place->name }}** has been **{{ ucfirst($booking->status) }}**.

@if($booking->status == 'rejected')
### Reason for Rejection:
{{ $messageContent }}
@endif

Thank you for choosing us! <br>
We hope to see you soon.<br>
**{{ config('app.name') }}**
@endcomponent

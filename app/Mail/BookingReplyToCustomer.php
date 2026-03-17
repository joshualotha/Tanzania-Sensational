<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingReplyToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $subjectLine,
        public string $messageBody
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
            replyTo: [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking.admin_reply',
            with: [
                'booking' => $this->booking,
                'messageBody' => $this->messageBody,
            ],
        );
    }
}


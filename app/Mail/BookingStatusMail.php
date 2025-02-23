<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($booking, $messageContent)
    {
        $this->booking = $booking;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("Your Booking Request has been " . ucfirst($this->booking->status))
                    ->markdown('emails.booking.status')
                    ->with([
                        'booking' => $this->booking,
                        'messageContent' => $this->messageContent,
                    ]);
    }
}

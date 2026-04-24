<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesanan;
    public $action;

    /**
     * Create a new message instance.
     */
    public function __construct(Pemesanan $pemesanan, $action)
    {
        $this->pemesanan = $pemesanan;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->action === 'baru' ? 'Pesanan Baru Masuk' : 'Pesanan Dibatalkan';
        return new Envelope(
            subject: $subject . ': ' . $this->pemesanan->no_nota,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_notification',
        );
    }
}

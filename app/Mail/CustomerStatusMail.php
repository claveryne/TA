<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesanan;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Pemesanan $pemesanan, $status)
    {
        $this->pemesanan = $pemesanan;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Pesanan: ' . $this->pemesanan->no_nota,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (strtolower($this->status) === 'disetujui') {
            $pdf = Pdf::loadView('pdf.nota', ['pemesanan' => $this->pemesanan]);
            return [
                Attachment::fromData(fn () => $pdf->output(), 'Nota_'.$this->pemesanan->no_nota.'.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}

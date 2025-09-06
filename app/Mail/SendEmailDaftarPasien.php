<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailDaftarPasien extends Mailable
{
    use Queueable, SerializesModels;
    public $pasien;
    public $rekam_medis;

    /**
     * Create a new message instance.
     */
    public function __construct($pasien, $rekam_medis)
    {
        // dd($pasien);
        $this->pasien = $pasien;
        $this->rekam_medis = $rekam_medis;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Pasien',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.send-email-daftar-pasien',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

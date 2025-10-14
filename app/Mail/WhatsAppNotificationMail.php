<?php

namespace App\Mail;

use App\Models\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WhatsAppNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $whatsappMessage;
    public $adminEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(WhatsAppMessage $whatsappMessage, $adminEmail)
    {
        $this->whatsappMessage = $whatsappMessage;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'رسالة واتساب جديدة من ' . $this->whatsappMessage->from_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.whatsapp-notification',
            with: [
                'whatsappMessage' => $this->whatsappMessage,
                'adminEmail' => $this->adminEmail
            ]
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

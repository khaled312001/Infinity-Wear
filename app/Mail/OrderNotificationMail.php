<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $adminEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $adminEmail)
    {
        $this->order = $order;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'طلب جديد - ' . $this->order->order_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-notification',
            with: [
                'order' => $this->order,
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

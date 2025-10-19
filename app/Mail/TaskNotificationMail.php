<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $action;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->action) {
            'created' => 'New Task Created - Infinity Wear',
            'updated' => 'Task Updated - Infinity Wear',
            'completed' => 'Task Completed - Infinity Wear',
            'assigned' => 'Task Assigned to You - Infinity Wear',
            default => 'Task Notification - Infinity Wear'
        };

        return new Envelope(
            subject: $subject,
            from: config('mail.from.address', 'info@infinitywearsa.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task-notification',
            with: [
                'task' => $this->task,
                'action' => $this->action,
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

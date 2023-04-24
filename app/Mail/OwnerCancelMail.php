<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OwnerCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $lesson;
    public $lessonDate;
    public $startTime;
    public $endTime;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $lesson, $lessonDate, $startTime, $endTime)
    {
        $this->user = $user;
        $this->lesson = $lesson;
        $this->lessonDate = $lessonDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'レッスンのキャンセル',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.owner_canceled',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

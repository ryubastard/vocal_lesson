<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $lesson;
    public $reserved_people;
    public $lessonDate;
    public $startTime;
    public $endTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $lesson, $reserved_people, $lessonDate, $startTime, $endTime)
    {
        $this->user = $user;
        $this->lesson = $lesson;
        $this->reserved_people = $reserved_people;
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
            subject: 'レッスン予約完了',
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
            view: 'emails.reservation_completed',
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

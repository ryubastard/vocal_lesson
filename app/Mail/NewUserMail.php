<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reserved_people;
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
    public function __construct($user, $reserved_people, $lesson, $lessonDate, $startTime, $endTime)
    {
        $this->user = $user->name;
        $this->reserved_people = $reserved_people;
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
            subject: '会員登録完了＆レッスン予約完了',
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
            view: 'emails.new_user_completed',
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

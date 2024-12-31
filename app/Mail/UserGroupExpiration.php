<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserGroupExpiration extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $userName, public string $groupName)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Group Expiration',
        );
    }

    public function build(): UserGroupExpiration
    {
        return $this->subject('Уведомление об истечении участия в группе')
            ->view('emails.group_expiration')
            ->with([
                'userName' => $this->userName,
                'groupName' => $this->groupName,
            ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.group_expiration',
        );
    }

}

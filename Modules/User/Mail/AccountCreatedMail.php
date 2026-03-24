<?php

namespace Modules\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $password
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Account Has Been Created',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'user::emails.account-created',
        );
    }
}

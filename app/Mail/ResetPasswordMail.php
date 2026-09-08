<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $url,
        public string $userName,
        public int $expireMinutes,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your Job4U password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.reset-password',
            with: [
                'url' => $this->url,
                'userName' => $this->userName,
                'expireMinutes' => $this->expireMinutes,
                'appName' => config('app.name', 'Job4U'),
                'appUrl' => config('app.url'),
                'logoPath' => public_path('images/logo-email.jpg'),
            ],
        );
    }
}

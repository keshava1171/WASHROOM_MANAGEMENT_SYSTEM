<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $staffName;
    public $staffEmail;
    public $tempPassword;
    public $loginUrl;
    protected $fromAdmin;

    public function __construct(string $staffName, string $staffEmail, string $tempPassword, $fromAdmin = null)
    {
        $this->staffName   = $staffName;
        $this->staffEmail  = $staffEmail;
        $this->tempPassword = $tempPassword;
        $this->loginUrl    = route('login');
        $this->fromAdmin   = $fromAdmin;
    }

    public function envelope(): Envelope
    {
        $fromName = $this->fromAdmin ? $this->fromAdmin->name : config('mail.from.name');
        $fromEmail = $this->fromAdmin ? $this->fromAdmin->email : config('mail.from.address');

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromEmail, $fromName),
            subject: 'Your HWMS Staff Account Is Ready',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.staff.welcome',
            with: [
                'staffName'   => $this->staffName,
                'staffEmail'  => $this->staffEmail,
                'tempPassword'=> $this->tempPassword,
                'loginUrl'    => $this->loginUrl,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

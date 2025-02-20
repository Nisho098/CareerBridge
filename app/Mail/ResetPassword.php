<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $formData; // Public property to pass data to the view

    /**
     * Create a new message instance.
     *
     * @param array $formData
     */
    public function __construct($formData)
    {
        $this->formData = $formData; // Assign data to property
    }

    /**
     * Get the envelope for the email.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $envelope = new Envelope();
        $envelope->subject($this->formData['mailSubject']);
        return $envelope;
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function content(): Content
    {
        return new Content(
            view: 'frontend.Account.resetPassword'

        );
    }
}


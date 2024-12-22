<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $isUserCopy;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, bool $isUserCopy = false)
    {
        $this->contact = $contact;
        $this->isUserCopy = $isUserCopy;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->isUserCopy 
            ? 'Thank you for contacting Chemico' 
            : 'New Contact Form Submission';

        return $this->subject($subject)
                   ->view('emails.contact-form');
    }
}

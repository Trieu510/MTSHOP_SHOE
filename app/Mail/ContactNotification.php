<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Contact instance.
     *
     * @var \App\Models\Contact
     */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Liên hệ mới từ ' . $this->contact->name)
                    ->view('emails.contact_notification')
                    ->with([
                        'name'    => $this->contact->name,
                        'email'   => $this->contact->email,
                        'phone'   => $this->contact->phone,
                        'message' => $this->contact->message,
                    ]);
    }
}

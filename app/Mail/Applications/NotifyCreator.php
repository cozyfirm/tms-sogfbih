<?php

namespace App\Mail\Applications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyCreator extends Mailable{
    use Queueable, SerializesModels;

    public $_what, $_name, $_gender, $_instance_id, $_instance_name;
    public string $_email_subject = 'Prijava na obuku';
    /**
     * Create a new message instance.
     */
    public function __construct($what, $name, $gender, $instance_id, $instance_name){
        $this->_what = $what;
        $this->_name = $name;
        $this->_gender = $gender;
        $this->_instance_id = $instance_id;
        $this->_instance_name = $instance_name;

        if($what != 'sign_up') $this->_email_subject = 'Odjava sa obuke';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope{
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('APP_NAME')),
            subject: __($this->_email_subject),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'user-data.trainings.emails.applications.notify-creator',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

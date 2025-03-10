<?php

namespace App\Mail\Evaluations;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyCreator extends Mailable
{
    use Queueable, SerializesModels;
    public string $_gender, $_name, $_instance_id, $_instance_title;

    /**
     * Create a new message instance.
     */
    public function __construct($gender, $name, $instance_id, $instance_title){
        $this->_gender = $gender;
        $this->_name = $name;
        $this->_instance_id = $instance_id;
        $this->_instance_title = $instance_title;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope{
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('APP_NAME')),
            subject: 'Evaluacija obuke',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'user-data.trainings.emails.evaluations.notify-creator',
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    public function __construct($name, $subject, $messageContent, $email)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->email = $email;
    }

    public function build()
    {
        return $this->replyTo($this->email, $this->name) // <- permet au destinataire de répondre
            ->subject($this->subject)
            ->view('email.contact');
    }
}

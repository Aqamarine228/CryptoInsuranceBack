<?php

namespace Modules\Client\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private string  $name,
        private string  $email,
        private ?string $phone,
        public          $subject,
        private string  $text
    )
    {
    }

    public function build()
    {
        return $this->view('emails.contact')->with([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'text' => $this->text,
        ]);
    }
}

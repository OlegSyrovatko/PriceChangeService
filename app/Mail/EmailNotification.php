<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $price;

    public function __construct($link, $price)
    {
        $this->link = $link;
        $this->price = $price;
    }

    public function build()
    {
        return $this->view('emails.email-notification');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Otp;
use Auth;

class resetEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_to, $link;

    public function __construct($mail, $link)
    {
        $this->mail_to = $mail;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
       
        return $this->view('email.resetEmail')->subject('Reset Your '. setting('site.title') .' Password')->with('link', $this->link)->to($this->mail_to);
    }
}

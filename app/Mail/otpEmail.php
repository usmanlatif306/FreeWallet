<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Otp;
use Auth;

class otpEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_to, $otp;

    public function __construct($mail, $otp)
    {
        $this->mail_to = $mail;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('email.otpEmail')->subject('Verify Your New ' . setting('site.title') . ' Account')->with('otp', $this->otp)->to($this->mail_to);
    }
}

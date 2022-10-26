<?php

namespace App\Mail\Withdrawal;

use App\User;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class withdrawalRequestAdminNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $withdrawal, $user; 

    public function __construct(Withdrawal $withdrawal, User $user)
    {
        $this->withdrawal = $withdrawal;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New withdrawal waiting review')->view('email.withdrawal.withdrawalRequestAdminNotificationEmail')->with('withdrawal', $this->withdrawal)->with('user', $this->user)->to(setting('admin.admin_email'));
    }
}

<?php

namespace App\Mail\Withdrawal;

use App\User;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class withdrawalCompletedUserNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $withdrawal;
    public $user;
    public function __construct(Withdrawal $withdrawal, User $user)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
          
        return $this->subject('Withdrawal completed')->view('email.withdrawal.withdrawalCompletedUserNotificationEmail')->with('withdrawal', $this->withdrawal)->with('user', $this->user)->to($this->user->email);
    
    }
}

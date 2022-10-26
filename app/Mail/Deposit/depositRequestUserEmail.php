<?php

namespace App\Mail\Deposit;

use App\User;
use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class depositRequestUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public $deposit_id, $user_id; 

    public function __construct(Deposit $deposit_id, User $user_id)
    {
        $this->deposit_id = $deposit_id;
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your deposit is being reviewed')->view('email.deposit.depositRequestUserEmail')->with('deposit', $this->deposit_id)->with('user', $this->user_id)->to($this->user_id->email);
    }
}

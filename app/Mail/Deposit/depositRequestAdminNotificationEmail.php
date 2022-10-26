<?php

namespace App\Mail\Deposit;

use App\User;
use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class depositRequestAdminNotificationEmail extends Mailable
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
        return $this->subject('New deposit waiting review')->view('email.deposit.depositRequestAdminNotificationEmail')->with('deposit', $this->deposit_id)->with('user', $this->user_id)->to(setting('admin.admin_email'));
    }
}

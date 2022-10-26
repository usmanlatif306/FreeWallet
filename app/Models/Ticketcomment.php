<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ticketcomment extends Model {

	protected $fillable = [ 'ticket_id', 'user_id', 'comment'];

	public function ticket()
	{
	    return $this->belongsTo(Ticket::class);
	}

	public function user()
	{
	    return $this->belongsTo(User::class);
	}
}
<?php

namespace App\Models;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{	
	protected $fillable = [
	    'user_id', 'ticketcategory_id', 'ticket_id', 'title', 'priority', 'message', 'status'
	];

	public function category()
	{
	    return $this->belongsTo(Ticketcategory::class, 'ticketcategory_id');
	}

	public function comments()
	{
	    return $this->hasMany(Ticketcomment::class);
	}

	public function user()
	{
	    return $this->belongsTo(User::class);
	}

}
<?php

namespace App\Models;

use App\User;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{	
	protected $fillable = ['user_id','phone_number', 'document_type', 'document'];


	public function User(){
		return $this->belongsTo(User::class);
	}

	public function document(){
		 return Storage::url($this->document);
	}

}

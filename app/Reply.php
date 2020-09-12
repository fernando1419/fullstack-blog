<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id'); // otherwise it will asume 'owner_id' because of the relation name.
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	/**
	 * _path. Specific thread resource.
	 *
	 * @return string
	 */
	public function _path() // cannot use path() for name it seems it is a reserved word.
	{
		return '/threads/' . $this->id;
	}
}

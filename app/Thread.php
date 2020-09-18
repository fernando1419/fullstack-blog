<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Thread extends Model
{
	protected $guarded = [];

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::addGlobalScope('replyCount', function (Builder $builder)
		{
			$builder->withCount('replies');
		});
	}

	/**
	 * _path. Specific thread resource.
	 *
	 * @return string
	 */
	public function _path() // cannot use path() for name it seems it is a reserved word.
	{
		return "/threads/{$this->channel->slug}/{$this->id}";
	}

	public function replies()
	{
		return $this->hasMany(Reply::class);
	}

	public function creator()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function channel()
	{
		return $this->belongsTo(Channel::class);
	}

	/**
	 * addReply
	 *
	 * @param mixed $reply
	 * @return void
	 */
	public function addReply($reply)
	{
		return $this->replies()->create($reply); // automatically gets the thread_id because of the relation.
	}
}

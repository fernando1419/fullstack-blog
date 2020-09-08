<?php

use App\Thread;
use Illuminate\Database\Seeder;

class RepliesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$threads = Thread::all();
		$threads->each(function ($thread)
		{
			factory('App\Reply', 10)->create(['thread_id' => $thread->id]);
		});
	}
}

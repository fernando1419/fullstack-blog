<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_thread_has_a_reply()
	{
		$thread = factory('App\Thread')->create();

		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
	}
}

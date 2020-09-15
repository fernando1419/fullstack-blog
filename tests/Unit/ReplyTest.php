<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_has_an_owner()
	{
		$reply = factory('App\Reply')->create();

		$this->assertInstanceOf('App\User', $reply->owner);
	}

	/** @test */
	public function a_reply_requires_a_body()
	{
		// given an authenticated user
		$this->actingAs($user = factory('App\User')->create());
		// an existing thread
		$thread = factory('App\Thread')->create();
		// and also a reply without a body
		$reply = factory('App\Reply')->make(['body' => null]);

		// when a user adds a reply to a thread (post request)
		$this->post($thread->_path() . '/replies', $reply->toArray())
			  ->assertSessionHasErrors('body'); // then session array has a variable called body.
	}
}

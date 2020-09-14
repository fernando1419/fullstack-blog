<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInThreadTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function unauthenticated_users_cannot_add_threads()
	{
		$this->withoutExceptionHandling();

		$this->expectException('Illuminate\Auth\AuthenticationException');

		$this->post('/threads/1/replies', []);
	}

	/** @test */
	public function an_authenticated_user_may_participate_in_threads()
	{
		// given an logged in user.
		$user = factory('App\User')->create();
		$this->be($user);
		// and an existing thread
		$thread = factory('App\Thread')->create();

		// when a user adds a reply to a thread (post request with reply data)
		$reply = factory('App\Reply')->make();
		$this->post($thread->_path() . '/replies', $reply->toArray());

		// then its reply should be visible on the page.
		$response = $this->get($thread->_path()); // dd($thread->_path()); // "/trreads/1"
		$response->assertSee($reply->body);
	}
}

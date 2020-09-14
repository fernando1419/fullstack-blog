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
		// $this->withoutExceptionHandling();
		// $this->expectException('Illuminate\Auth\AuthenticationException');
		$this->post('/threads/any-channel/1/replies', [])
			 ->assertRedirect('/login');
	}

	/** @test */
	public function an_authenticated_user_may_participate_in_threads()
	{
		// given an logged in user.
		$user = factory('App\User')->create();
		$this->be($user);
		// and an existing thread
		$thread = factory('App\Thread')->create();
		// dd($thread->_path()); e.g. "/threads/laroriom/1"

		// when a user adds a reply to a thread (post request with reply data)
		$reply = factory('App\Reply')->make();
		$this->post($thread->_path() . '/replies', $reply->toArray());

		// then its reply should be visible on the page.
		$response = $this->get($thread->_path());
		$response->assertSee($reply->body);
	}
}

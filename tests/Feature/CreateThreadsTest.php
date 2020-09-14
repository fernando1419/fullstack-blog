<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function guests_cannot_create_threads()
	{
		$this->withExceptionHandling(); // default behaviour

		$this->get('/threads/create') // when a non-authenticated user hits the endpoint for displaying a form to create a thread
			  ->assertRedirect('/login'); // then it should redirect to the login page.

	   $this->post('/threads') // when a non-authenticated user hits the endpoint for storing a thread
			  ->assertRedirect('/login'); // then it should redirect to the login page.
	}

	/** @test */
	public function an_authenticated_user_can_create_a_thread() // tests that backupsup when the form gets submitted
	{
		// given a logged user
		$user = factory('App\User')->create();
		$this->actingAs($user);
		// and the necesary data for creating a thread (that is why we use make() and not create())
		$thread = factory('App\Thread')->make();

		// when hit the endpoint to create a new thread with
		$this->post('/threads', $thread->toArray());

		// then when we visit the threads page
		$response = $this->get($thread->_path());
		// we should see the new created thread
		$response->assertSee($thread->title);
		$response->assertSee($thread->body);
	}
}

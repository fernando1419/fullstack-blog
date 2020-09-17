<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
	use RefreshDatabase;

	public function setUp(): void // without (): void gives an error.
	{
		parent::setUp();
		$this->withoutExceptionHandling(); // without this line phpunit returns all the stacktrace error (lot of garbage in screen).

		$this->thread = factory('App\Thread')->create(); // given
	}

	/** @test */
	public function it_can_browse_all_threads() // tests index request
	{
		$response = $this->get('/threads'); // when

		$response->assertStatus(200);
		$response->assertSee($this->thread->title);
		$response->assertSee($this->thread->body);
	}

	/** @test */
	public function it_can_browse_a_single_thread() // tests show request
	{
		$response = $this->get($this->thread->_path()); // when getting a particular thread

		$response->assertStatus(200); // then
		$response->assertSee($this->thread->title);
		$response->assertSee($this->thread->body);
	}

	/** @test */
	public function it_can_browse_replies_associated_with_a_thread() // tests a thread has replies associated
	{
		$reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]); // given a reply for a thread

		$response = $this->get($this->thread->_path());
		// same as: $response = $this->get('/threads/' . $this->thread->id);

		$response->assertSee($reply->body);
	}

	/** @test */
	public function a_user_can_filter_threads_according_to_a_channel()
	{
		$channel              = factory('App\Channel')->create(); // given we have a channel
	   $threadInChannel    = factory('App\Thread')->create(['channel_id' => $channel->id]); // an a thread that belongs to that channel
	   $threadNotInChannel = $this->thread; // and another thread that doesn't belong to that channel

	   $this->get("/threads/{$channel->slug}") // when call this url
			->assertSee($threadInChannel->title) // then we spect to see this channel
			->assertDontSee($threadNotInChannel->title); // and not this one.
	}

	/** @test */
	public function an_authenticated_user_can_filter_threads_by_his_name()
	{
		$this->actingAs(factory('App\User')->create(['name' => 'Juan'])); // given a signedin user.
		$threadByJuan      = factory('App\Thread')->create(['user_id' => auth()->id()]); // and thread associated with Juan
	   $threadNotByJuan = $this->thread; // and also a thread of a different user

	   $this->get('/threads?by=Juan') // when calling this uri
			->assertSee($threadByJuan->title) // we expect to see the title of Juan's thread
		   ->assertDontSee($threadNotByJuan->title); // and not see the title of not Juan's thread
	}
}

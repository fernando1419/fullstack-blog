<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
	use RefreshDatabase;

	public function setUp(): void
	{
		parent::setUp();

		$this->thread = factory('App\Thread')->create();
	}

	/** @test */
	public function a_thread_can_make_a_string_path()
	{
		$thread = factory('App\Thread')->create(); // given a thread

		// dd("/threads/{$thread->channel->slug}/$thread->id");
		$this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->_path());
	}

	/** @test */
	public function a_thread_has_a_creator()
	{
		$this->assertInstanceOf('App\User', $this->thread->creator);
	}

	/** @test */
	public function a_thread_has_replies()
	{
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
	}

	/** @test */
	public function a_thread_can_add_a_reply()
	{
		$this->thread->addReply([
		 'body'    => 'Body',
		 'user_id' => 1
	  ]);

		$this->assertCount(1, $this->thread->replies);
	}

	/** @test */
	public function a_thread_belongs_to_a_channel()
	{
		$thread = factory('App\Thread')->create();

		$this->assertInstanceOf('App\Channel', $thread->channel);
	}

	/** @test */
	public function a_thread_requires_a_title()
	{
		$response = $this->publishThread(['title' => null]); // and a thread without a title

		$response->assertSessionHasErrors('title'); // we should see a title variable in sessions array.
	}

	/** @test */
	public function a_thread_requires_a_body()
	{
		$response = $this->publishThread(['body' => null]); // and a thread without a body

		$response->assertSessionHasErrors('body'); // we should see a body variable in sessions array.
	}

	/** @test */
	public function a_thread_requires_a_valid_channel()
	{
		$this->publishThread(['channel_id' => null]) // and a thread without a channel_id
			 ->assertSessionHasErrors('channel_id'); // we should see a channel_id variable in sessions array.

		factory('App\Channel', 2)->create();

		$this->publishThread(['channel_id' => 9999999]) // non existing channel_id
		   ->assertSessionHasErrors('channel_id'); // we should see a channel_id variable in sessions array.
	}

	public function publishThread($attributes = [])
	{
		$this->actingAs($user = factory('App\User')->create()); // given a logged in user

		$thread = factory('App\Thread')->make($attributes); // and a thread without a title

		return $this->post('/threads', $thread->toArray()); // when we make a post request to this endpoint
	}
}

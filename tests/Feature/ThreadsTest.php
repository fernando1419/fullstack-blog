<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_can_browse_all_threads()
	{
		$thread = factory('App\Thread')->create(); // given

		$response = $this->get('/threads'); // when

		$response->assertStatus(200);
		$response->assertSee($thread->title);
		$response->assertSee($thread->body);
	}

	/** @test */
	public function it_can_browse_a_single_thread()
	{
		$thread = factory('App\Thread')->create(); // given

		$response = $this->get('/threads/' . $thread->id); // when getting a particular thread

		$response->assertStatus(200); // then
		$response->assertSee($thread->title);
		$response->assertSee($thread->body);
	}
}

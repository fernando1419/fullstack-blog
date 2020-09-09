<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_can_browse_threads()
	{
		$thread = factory('App\Thread')->create(); // given

		$response = $this->get('/threads'); // when

		$response->assertStatus(200);
		$response->assertSee($thread->title);
		$response->assertSee($thread->body);
	}
}

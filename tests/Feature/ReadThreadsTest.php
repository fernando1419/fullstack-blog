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
		$response = $this->get('/threads/' . $this->thread->id); // when getting a particular thread

		$response->assertStatus(200); // then
		$response->assertSee($this->thread->title);
		$response->assertSee($this->thread->body);
	}

	/** @test */
	public function it_can_browse_replies_associated_with_a_thread() // tests a thread has replies associated
	{
		$reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]); // given a reply for a thread

		$response = $this->get('/threads/' . $this->thread->id);

		$response->assertSee($reply->body);
	}
}

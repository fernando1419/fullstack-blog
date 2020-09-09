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
		$response = $this->get('/threads');

		$response->assertStatus(200);
	}
}

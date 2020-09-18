<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use App\Channel;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->except(['index', 'show']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  Channel $channel.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Channel $channel)
	{
		if ($channel->exists) {
			$threads = $channel->threads()->latest();
		} else {
			$threads = Thread::latest();
		}
		// if request('by'), we should filter by the given username
		if ($username = request('by')) {
			$user = User::where('name', $username)->firstOrFail();

			$threads->where('user_id', $user->id);
		}

		$threads = $threads->get();

		return view('threads.index', compact('threads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('threads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// dd($request->all());
		$this->validate($request, [ // redirects back with errors if validation fails.
		   'title'      => 'required',
		   'body'       => 'required',
		   'channel_id' => 'required|exists:channels,id',
	   ]);

		$thread = Thread::create([
		   'user_id'    => auth()->id(),
		   'channel_id' => $request->channel_id,
		   'title'      => $request->title, // same as: 'title' => request('title'),
		   'body'       => $request->body // same as: 'body' => request('body')
	   ]);

		return redirect($thread->_path());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param mixed $channelId
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
	public function show($channelId, Thread $thread)
	{
		return view('threads.show', [
		   'thread'  => $thread,
		   'replies' => $thread->replies()->paginate(10) // json format
	   ]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Thread $thread)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Thread $thread)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Thread $thread)
	{
		//
	}
}

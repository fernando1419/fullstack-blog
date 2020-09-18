@extends('layouts.app')

@section('content')

<div class="container">

   <div class="row justify-content-left">

      <div class="col-md-8">

         <!-- Thread Information -->
         <div class="card">
            <div class="card-header">
               <a href="#"> {{ $thread->creator->name }} </a> posted: {{ $thread->title }}
            </div>
            <div class="card-body"> {{ $thread->body }} </div>
         </div>

         <!-- Replies to the thread -->
         @foreach ($replies as $reply)
            @include ('threads._reply')
         @endforeach

         <!-- paginating replies -->
         <br/>
         {{ $replies->links() }}

         <!-- Form to add a new Reply -->
         <div class="mt-3">
            @if (auth()->check())
               <form method="POST" action="{{ $thread->_path() . '/replies' }}">
                  @csrf
                  <div class="form-group">
                     <div class="form-group">
                        <textarea class="form-control" name="body" id="body" rows="4" placeholder="Enter your comment here.."></textarea>
                     </div>
                     <button type="submit" class="btn btn-primary btn-sm">Post your comment</button>
                  </div>
               </form>
            @else
               <p class="text-center">Please <a href="{{ route('login') }}"> sign in</a> to participate in this thread </p>
            @endif
         </div>

      </div>

      <!-- Right Panel with information about the thread -->
      <div class="col-md-4">
         <div class="card">
            <div class="card-body">
               <p>
                  This thread was published {{ $thread->created_at->diffForHumans() }} by
                  <a href="#"> {{ $thread->creator->name }} </a>, and currently has {{ $thread->replies_count }}
                  {{ Str::plural('comment', $thread->replies_count) }}.
               </p>
            </div>
         </div>
      </div>

   </div>

</div>

@endsection

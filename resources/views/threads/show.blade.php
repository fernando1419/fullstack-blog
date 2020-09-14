@extends('layouts.app')

@section('content')
<div class="container">

   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">
               <a href="#"> {{ $thread->creator->name }} </a> posted: {{ $thread->title }}
            </div>
            <div class="card-body"> {{ $thread->body }} </div>
         </div>
      </div>
   </div>

   <div class="row justify-content-center">
      <div class="col-md-8">
         @foreach ($thread->replies as $reply)
            @include ('threads._reply')
         @endforeach
      </div>
   </div>

   @if (auth()->check())
      <div class="row justify-content-center mt-3">
         <div class="col-md-8">
            <form method="POST" action="{{ $thread->_path() . '/replies' }}">
               @csrf
               <div class="form-group">
                  <div class="form-group">
                     <textarea class="form-control" name="body" id="body" rows="4" placeholder="Enter your comment here.."></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Post your comment</button>
               </div>
            </form>
         </div>
      </div>
   @else
      <p class="text-center mt-3">Please <a href="{{ route('login') }}"> sign in</a> to participate in this thread </p>
   @endif

</div>
@endsection

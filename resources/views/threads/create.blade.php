@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">

            <div class="card-header text-center"> Create a Thread </div>

            <div class="card-body">
               <form method="POST" action="{{ route('threads.store') }}">
                  @csrf
                  <div class="form-group">
                     <label   label for="channel_id">Choose a channel</label>
                     <select class="form-control" name="channel_id" id="channel_id" required>
                        <option value="">Choose one...</option>
                        @foreach ($channels as $channel)
                           <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                              {{ $channel->name }}
                           </option>
                        @endforeach
                     </select>
                  </div>

                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                  </div>
                  <div class="form-group">
                     <label for="body">Body</label>
                     <textarea class="form-control" name="body" id="body" rows="4" required> {{ old('body') }} </textarea>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Publish</button>
                  </div>
               </form>

               <!-- errors -->
               @if (count($errors))
                  <ul class="alert alert-danger">
                     @foreach ($errors->all() as $error)
                        <li> {{ $error }} </li>
                     @endforeach
                  </ul>
               @endif

            </div>

         </div>
      </div>
   </div>
</div>
@endsection

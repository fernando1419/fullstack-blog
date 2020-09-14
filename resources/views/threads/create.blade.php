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
                     <label for="title">Title</label>
                     <input type="text" class="form-control" name="title" id="title">
                  </div>
                  <div class="form-group">
                     <label for="body">Body</label>
                     <textarea class="form-control" name="body" id="body" rows="6"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Publish</button>
               </form>
            </div>

         </div>
      </div>
   </div>
</div>
@endsection

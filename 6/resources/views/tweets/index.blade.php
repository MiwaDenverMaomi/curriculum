@extends('layouts.app')
@section('content')
	<div class="container col-xs-10 col-md-4 ">
	 <div class="card  mb-4">
		<div class="card-body">
		<h5 class="card-title">{{__('message.Home')}}</h5>
		<hr>
	<form action="{{route('tweets.create')}}" method="post">
		@csrf
	 <div class="mb-3">
		@if(session('flash_message_error'))
		   <span class="ml-3 text-danger">{{session('flash_message_error')}}</span>
		@endif
		@error('post')
		  <span class="ml-3 text-danger">{{$message}}</span>
		@enderror
			<input type="text" class="form-control mb-3" id="post" placeholder="{{__('message.Whats up?')}}" name="post">
		<div class="text-right">
			<button type="submit" class="btn btn-primary">{{__('message.Submit')}}</button>
		</div>
	 </div>
	</form>
	</div>
 </div>
	 <ul class="list-group">
		@isset($posts)
			@foreach($posts as $post)
		<li class="list-group-item">
			<div class="container text-center">
				<div class="row justify-content-between">
		<div class="col-4 mb-3 font-weight-bold text-wrap">
			{{$post->user->name}}
		</div>
		<div class="col-4">
			{{$post->updated_at}}
		</div>
	</div>
			</div>
			<p class="text-wrap">{{$post->body}}</p>
			@if(Auth::id()==$post->user->id)
			<form action="{{route('tweets.delete',['post'=>$post->id])}}">
			 <div class="text-right">
				@if(session('flash_message_delete_failed'))
		     <span class="ml-3 text-danger">{{session('flash_message_delete_failed')}}</span>
		    @endif
				<button type="submit" class="btn btn-danger">{{__('message.Delete')}}</button>
			 </div>
		  </form>
			@endif
		</li>
			@endforeach
		@endisset
</ul>
	</div>
@endsection

@extends('layouts.app')

@section('content')
    <a href="/events" class="btn btn-default">Go Back</a>
    <h1>{{$event->name}}</h1>
    <img style="width: 100%" src="/storage/event_images/{{$event->event_image}}" alt="">
    <br><br>
    <div>
        {!!$event->description!!}
    </div>
    <hr>
    <small>Written on {{$event->created_at}} by {{$event->user->name}}</small>
    <hr>
    @if(Auth::user()->id == $event->user_id)
        <a href="/events/{{$event->id}}/edit" class="btn btn-default">Edit</a>

        {!!Form::open(['action' => ['EventsController@destroy', $event->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
@endsection
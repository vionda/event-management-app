@extends('layouts.app')

@section('content')
    <h1>Events</h1>
    @if(count($events) > 0)
        @foreach($events as $event)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width: 100%" src="/storage/event_images/{{$event->event_image}}" alt="">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/events/{{$event->id}}">{{$event->name}}</a></h3>
                        <small>Written on {{$event->created_at}} by {{$event->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$events->links()}}
    @else 
        <p>No Events found</p>
    @endif
@endsection
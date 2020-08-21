@extends('layouts.app')

@section('content')
    <h1>Edit Event</h1>
    {!! Form::open(['action' => ['EventsController@update', $event->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name of the Event')}}
            {{Form::text('name', $event->name,  ['class' => 'form-control', 'placeholder' => 'Event Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'The Description of the Event')}}
            {{Form::textarea('description', $event->description,  ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::file('event_image')}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
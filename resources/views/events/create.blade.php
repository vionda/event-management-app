@extends('layouts.app')

@section('content')
    <h1>Create Event</h1>
    {!! Form::open(['action' => 'EventsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{ csrf_field() }}
            <div class="form-group">
                {{Form::label('name', 'Name of the Event')}}
                {{Form::text('name', '',  ['class' => 'form-control', 'placeholder' => 'Event Name'])}}
            </div>
            <div class="form-group">
                {{Form::label('description', 'The Description of the Event')}}
                {{Form::textarea('description', '',  ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
            </div>
            <div class="form-group">
                {{Form::file('event_image')}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
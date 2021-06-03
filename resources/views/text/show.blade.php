@extends('layout')
@section('content')
    <h3>Title</h3>
    <p>{{$text->title}}</p>
    <h3>Title</h3>
    <p>
        {!! $text->content !!}
    </p>
@endsection

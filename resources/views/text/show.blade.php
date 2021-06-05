@extends('layout')
@section('content')
    <div class="container">
        <div class="text-item">
            <p class="text-item-lable">Title</p>
            <div class="text-item-content">
                {{$text->title}}
            </div>
        </div>
        <div class="text-item">
            <p class="text-item-lable">Content</p>
            <div class="text-item-content">
                {!! $text->content !!}
            </div>
        </div>
    </div>
@endsection

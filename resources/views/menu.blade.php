@extends('layout')
@section('menu')
    <div class="container">
        <a href="{{ rotue('home.index') }}">Chia sẻ file</a>
        <a href="{{ rotue('text.index') }}">Chia sẻ text</a>
        <a href="{{ rotue('user.login') }}">Đăng nhập</a>
        <a href="{{ rotue('user.register') }}">Đăng ký</a>
    </div>
@endsection

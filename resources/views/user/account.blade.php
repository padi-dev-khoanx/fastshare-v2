@extends('layout')
@section('content')
<div class="container">
    <h2>Tài khoản</h2>
    user đang login: {{auth()->user()->name}}
</div>
@endsection

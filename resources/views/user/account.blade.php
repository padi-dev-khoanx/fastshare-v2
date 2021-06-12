@extends('layout')
@section('content')
<div class="container">
    <h2>Tài khoản</h2>
    <br/>
{{--    user đang login: {{auth()->user()->name}}--}}
    <div class="account">
        <div class="info">
            <h4>Thông tin user</h4>
            <div>
                <p>Tên: {{auth()->user()->name}}</p>
                <p>Email: {{auth()->user()->email}}</p>
            </div>
        </div>
        <div class="items-management">
            <h4>Quản lý</h4>
        </div>
    </div>
</div>
@endsection

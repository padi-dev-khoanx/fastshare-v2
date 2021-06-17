@extends('layout')
@section('content')
    <div class="container small-container">
        @if($errors->any())
            <div class="alert alert-danger">
                <p>{{$errors->first()}}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h2>Sửa thông tin</h2>
                <p id="msg" class="error-msg"></p>
                <form class="form" id="registerForm" action=" {{ route('user.update') }}" method="POST">
                    @csrf
                    <label for="name">Tên</label>
                    <input id="name" type="text" name="name" value="{{auth()->user()->name}}" required/>
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email" required value="{{auth()->user()->email}}"/>
                    <label for="password">Mật khẩu</label>
                    <input id="password" type="password" name="password" required/>
                    <label for="repassword">Nhập lại mật khẩu</label>
                    <input id="repassword" type="password" name="repassword" required/>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection

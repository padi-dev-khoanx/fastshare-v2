@extends('layout')
@section('content')
    <div class="container small-container">
        <div class="card">
            <div class="card-body">
                <h2>Đăng ký</h2>
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    </div>
                @endif
                <form class="form" id="registerForm" action=" {{ route('user.create') }}" method="POST">
                    @csrf
                    <label for="name">Tên</label>
                    <input id="name" type="text" name="name" required/>
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email" required/>
                    <label for="password">Mật khẩu</label>
                    <input id="password" type="password" name="password" required/>
                    <label for="repassword">Nhập lại mật khẩu</label>
                    <input id="repassword" type="password" name="repassword" required/>
                    <button type="submit" class="btn btn-primary">Đăng ký</button>

                </form>
                <a href="{{ route('user.login') }}">Đăng nhập bẳng tài khoản có sẵn!</a>
            </div>
        </div>
    </div>
@endsection

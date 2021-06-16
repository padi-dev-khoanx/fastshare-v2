<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fast Share - Chia sẻ nhanh</title>
    <link rel="stylesheet" href="{{asset('/css/dropzone.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> --}}
    <script type="text/javascript" src="{{asset('/js/dropzone.js')}}"></script>
</head>
<body>
<div class="header-menu">
    <div class="container">
        <div class="menu">
            <div class="menu-left">
                <a
                    href="{{ route('home.index') }}"
                    @if(Route::current()->getName() == 'home.index')
                        class="selected"
                    @endif
                >Chia sẻ file</a>
                <a
                    href="{{ route('text.index') }}"
                    @if(Route::current()->getName() == 'text.index')
                        class="selected"
                    @endif
                >Chia sẻ text</a>
            </div>
            <p class="title-header">Fastshare - Chia sẻ nhanh</p>
            <div class="menu-right">
                @if(auth()->user())
                    <a
                        href="{{ route('user.account') }}"
                        @if(Route::current()->getName() == 'user.account')
                            class="selected"
                        @endif
                    >Chào {{auth()->user()->name}}</a>
                    <a href="{{ route('user.logout') }}">Đăng xuất</a>
                @else
                    <a href="{{ route('user.login') }}">Đăng nhập</a>
                    <a href="{{ route('user.register') }}">Đăng ký</a>
                @endif
            </div>
        </div>
    </div>
</div>
@yield('menu')
@yield('content')
</body>
</html>

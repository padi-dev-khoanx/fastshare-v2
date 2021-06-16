@extends('layout')
@section('content')
    <div class="container small-container">
        <div class="card">
            <div class="card-body">
                <h2>Đăng nhập</h2>
                <p id="msg" class="error-msg"></p>
                <form class="form" id="loginForm" action=" {{ route('user.auth') }}" method="POST">
                    @csrf
                    <label for="email">Email</label>
                    <input id="email" type="text" name="email"/>
                    <label for="password">Mật khẩu</label>
                    <input id="password" type="password" name="password"/>
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </form>
                <a href="{{ route('user.register') }}">Bạn chưa có tài khoản?</a>
            </div>
        </div>
    </div>
    <script>
        $("#loginForm").submit(function (event) {
            event.preventDefault();

            let form = $(this),
                email = $("input[name=email]").val(),
                password = $("input[name=password]").val(),
                url = form.attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    email: email,
                    password: password,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#msg').html();
                    if (response.status === 'success') {
                        window.location.href = "{{ route('user.account') }}";
                    } else {
                        if ($.isArray(response.msg)) {
                            let msg = [];
                            if (response.msg.email) {
                                msg.push(response.msg.email[0]);
                            }
                            if (response.msg.password) {
                                msg.push(response.msg.password[0]);
                            }
                            $('#msg').html(msg.join('<br/>'));
                        } else {
                            $('#msg').html(response.msg);
                        }
                    }
                },
            });
        });
    </script>
@endsection

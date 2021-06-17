@extends('layout')
@section('content')
    <div class="container small-container">
        <div class="card">
            <div class="card-body">
                <h2>Đăng ký</h2>
                <p id="msg" class="error-msg"></p>
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
    <script>
        $("#registerForm").submit(function (event) {
            event.preventDefault();

            let form = $(this),
                name = $("input[name=name]").val(),
                email = $("input[name=email]").val(),
                password = $("input[name=password]").val(),
                repassword = $("input[name=repassword]").val(),
                url = form.attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    repassword: repassword,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#msg').html();
                    if (response.status === 'success') {
                        window.location.href = "{{ route('user.account') }}";
                    } else {
                        if ($.isArray(response.msg)) {
                            let msg = [];
                            if (response.msg.name) {
                                msg.push(response.msg.name[0]);
                            }
                            if (response.msg.email) {
                                msg.push(response.msg.email[0]);
                            }
                            if (response.msg.password) {
                                msg.push(response.msg.password[0]);
                            }
                            if (response.msg.repassword) {
                                msg.push(response.msg.repassword[0]);
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

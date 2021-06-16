@extends('layout')
@section('content')
<div class="container">
    <h2>Tài khoản</h2>
    <br/>
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{!! \Session::get('success') !!}</p>
        </div>
    @endif
    <div class="account">
        <div class="info">
            <h4>Thông tin user</h4>
            <div>
                <p>Tên: {{auth()->user()->name}}</p>
                <p>Email: {{auth()->user()->email}}</p>
                @if(auth()->user()->type_user == 0)
                    <a class="btn btn-primary" style="background: #0087f7" href="{{route('user.buyVIP')}}">ĐĂNG KÝ VIP</a>
                @endif
            </div>
        </div>
        <div class="items-management">
            <h4>Quản lý tập tin tải lên</h4>
            <br>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Tên</th>
                    <th scope="col">Đường dẫn</th>
                    <th scope="col">Thời gian tải lên</th>
                    <th scope="col">Lượt tải còn lại</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>chitietgoi (1).png</td>
                        <td><a href="http://127.0.0.1:8000/MTIuLi4u">http://127.0.0.1:8000/MTIuLi4u</a></td>
                        <td>2021-06-04 02:46:42</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td>chitietgoi.png</td>
                        <td><a href="http://127.0.0.1:8000/MTIuLi3a">http://127.0.0.1:8000/MTIuLi3a</a></td>
                        <td>2021-06-04 02:43:23</td>
                        <td>2</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

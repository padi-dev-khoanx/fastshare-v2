@extends('layout')
@section('content')
    <div class="container">
        <h2>Quản trị</h2>
        <br/>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{!! \Session::get('success') !!}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <p>{{$errors->first()}}</p>
            </div>
        @endif
        <div class="account">
            <div class="items-management">
                <h4>Quản lý danh sách người dùng</h4>
                <br>
                <table class="table table-striped" id="table_id">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Địa chỉ email</th>
                        <th scope="col">Loại thành viên</th>
                        <th scope="col">Số tiền đã nạp</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listUser as $user)
                        <tr>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->id}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->name}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->email}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->type_user == 1 ? "VIP" : "Thường"}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{count($user->order)*5 . " USD"}}</p></td>
                            <td style="width: fit-content"><a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="{{route('user.delete',$user->id)}}">Xóa</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({
                "order": [[ 0, "desc" ]],
                "searching": false
            });
        } );
    </script>
@endsection

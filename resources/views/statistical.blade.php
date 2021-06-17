@extends('layout')
@section('content')
    <div class="container">
        <h2>Quản trị</h2>
        <br/>
        <div class="account">
            <div class="items-management">
                <h4>Quản lý tập tin tải lên</h4>
                <br>
                <table class="table table-striped" id="table_id">
                    <thead>
                    <tr>
                        <th scope="col">Tên</th>
                        <th scope="col">Địa chỉ email</th>
                        <th scope="col">Loại thành viên</th>
                        <th scope="col">Số tiền đã nạp</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listUser as $user)
                        <tr>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->name}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->email}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{$user->id == 1 ? "VIP" : "Thường"}}</p></td>
                            <td><p style="text-overflow: ellipsis; max-width: 300px; white-space: nowrap; overflow: hidden;">{{count($user->order)*5 . " USD"}}</p></td>
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
                "order": [[ 2, "desc" ]],
                "searching": false
            });
            $('#table_id_2').DataTable({
                "order": [[ 2, "desc" ]],
                "searching": false
            });
        } );
    </script>
@endsection

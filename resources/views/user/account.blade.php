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
    @if($errors->any())
        <div class="alert alert-danger">
            <p>{{$errors->first()}}</p>
        </div>
    @endif
    <div class="account">
        <div class="info">
            <h4>Thông tin user</h4>
            <div class="info-content">
                <p>Tên: {{auth()->user()->name}}</p>
                <p>Email: {{auth()->user()->email}}</p>
                <p><a href="{{route('user.edit')}}"><i class="fas fa-pen"></i> Chỉnh sửa thông tin cá nhân</a></p>
                @if(auth()->user()->type_user == 0)
                    <a class="btn btn-primary" style="background: #0087f7" href="{{route('user.buyVIP')}}">ĐĂNG KÝ VIP</a>
                @elseif(auth()->user()->type_user == 1)
                    <img src="{{asset('/img/star.png')}}" alt="" height="50px" style="margin-bottom: 10px">
                    <p>Hết hạn: {{date("d/m/Y", strtotime(auth()->user()->vip_end_date))}}</p>
                @endif
            </div>
        </div>
        <div class="items-management">
            <h4>Quản lý tập tin tải lên</h4>
            <br>
            <table class="table table-striped" id="table_id">
                <thead>
                  <tr>
                    <th scope="col">Tên</th>
                    <th scope="col">Đường dẫn</th>
                    <th scope="col">Thời gian tải lên</th>
                    <th scope="col">Lượt tải</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($userFile as $file)
                    <tr>
                        <td><p style="text-overflow: ellipsis; max-width: 200px; white-space: nowrap; overflow: hidden;">{{$file->name}}</p></td>
                        <td><a href="{{env("APP_URL") . '/' . $file->path_download}}"><p style="text-overflow: ellipsis; max-width: 200px; white-space: nowrap; overflow: hidden;">{{env("APP_URL") . '/' . $file->path_download}}</p></a></td>
                        <td style="width: fit-content">{{$file->created_at}}</td>
                        <td style="width: fit-content">{{$file->times_download}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="account">
        <div class="none"></div>
        <div class="items-management">
            <h4>Quản lý văn bản chia sẻ</h4>
            <br>
            <table class="table table-striped" id="table_id_2">
                <thead>
                <tr>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Đường dẫn</th>
                    <th scope="col">Thời gian tải lên</th>
                    <th scope="col">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($userText as $text)
                    <tr>
                        <td><p style="text-overflow: ellipsis; max-width: 200px; white-space: nowrap; overflow: hidden;">{{$text->title}}</p></td>
                        <td><a href="{{env("APP_URl") . '/text/' . $text->text_path}}"><p style="text-overflow: ellipsis; max-width: 200px; white-space: nowrap; overflow: hidden;">{{env("APP_URl") . '/text/' . $text->text_path}}</p></a></td>
                        <td style="width: fit-content">{{$text->created_at}}</td>
                        <td style="width: fit-content"><a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="{{route('text.delete',$text->id)}}">Xóa</a></td>
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

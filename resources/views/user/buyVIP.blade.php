@extends('layout')
@section('content')
    <div class="container small-container">
        <div class="card">
            <div class="card-body">
                <h2>MUA VIP</h2>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <p>{{$errors->first()}}</p>
                    </div>
                @endif
                <div class="about-vip">
                    Với 5$ bạn sẽ có 1 tháng là thành viên VIP với đặc quyền tải lên tối đa 200MB/tập tin thay vì chỉ là 100MB, có thể cài đặt lên tới 4 lần tải về cho 1 tập tin và thời gian tồn tại của tập tin là 7 ngày.
                </div>
                <form action="{{route('user.getVIP')}}" method="post" id="payment-form">
                    @csrf
                    <div class="form-group">
                        <label>Số thẻ</label>
                        <input type="text" class="form-control" placeholder="Số thẻ" name="card_number" required>
                    </div>
                    <div class="form-group">
                        <label>Tháng kết thúc</label>
                        <select class="form-control" name="month_exp" required>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Năm kết thúc</label>
                        <input type="number" class="form-control" placeholder="Năm kết thúc"  name="year_exp" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background: #0087f7">Thanh toán</button>
                </form>
            </div>
        </div>
    </div>
@endsection

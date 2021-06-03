<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Fast Share - Chia sẻ nhanh của Khoa</title>
    <link rel="stylesheet" href="{{asset('/css/dropzone.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> --}}
    <script type="text/javascript" src="{{asset('/js/dropzone.js')}}"></script>
</head>
<body>
    <h1 class="mt-5">Fastshare - Chia sẻ file nhanh</h1>
    <br>
    @yield('content')
</body>
</html>

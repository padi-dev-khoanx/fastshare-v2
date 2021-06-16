@extends('layout')
@section('content')
    @php
        $path = urlencode($file->path);
        $path = urldecode(str_replace('%5C','%2F', $path));
    @endphp
        <div class="container">
            <div class="frame">
                <div class="center preview_file mt-5">
                    @if (in_array($file->type, ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG']))
                        <img src='{{url($path)}}' data-zoom-image="{{url($path)}}" width="100%"/>
                    @elseif (in_array($file->type, ['txt', 'TXT']))
                        <p>{{$txtFile}}</p>
                    @elseif (in_array($file->type, ['flv', 'mp4', 'm3u8', 'ts', '3gp', 'mov', 'avi', 'wmv', 'webm']))
                        <video width="100%" controls>
                            <source src="{{url($path)}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>
            </div>
        </div>
    <script src='https://www.elevateweb.co.uk/wp-content/themes/radial/jquery.elevatezoom.min.js'></script>
    <script>
        $('img').elevateZoom({zoomType: "inner"});
    </script>
@endsection

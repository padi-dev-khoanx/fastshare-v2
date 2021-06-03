@extends('layout')
@section('content')
<div class="frame">
    <div class="center">
        <div class="upload-content">
            <form action="{{ url('download') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="dropzone">
                    <div class="content text-center">
                        <input name="filePath" value="{{$file->path}}" hidden>
                        <input name="fileName" value="{{$file->name}}" hidden>
                        @if ($isExists)
                            <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete text-center" id="exists">
                                <div class="dz-image">
                                    <img data-dz-thumbnail="" @if (in_array($file->type, ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG'])) src="{{$file->path}}" width="120px" height="120px" @endif >
                                    </div>
                                    <div class="dz-details">
                                        <div class="dz-size">
                                            <span data-dz-size="">
                                                <strong>{{round($file->size/(1024*1024),1)}}</strong> MB
                                            </span>
                                        </div>
                                        <div class="dz-filename">
                                            <span data-dz-name="">{{$file->name}}</span>
                                        </div>
                                    </div>
                                    <div class="dz-progress">
                                        <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                    </div>
                                    <div class="dz-success-mark">
                                        <?xml version="1.0"?>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="54px" height="54px"  x="0" y="0" viewBox="0 0 477.827 477.827" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path d="M441.537,160.625c1.489-7.981,2.243-16.082,2.253-24.201C443.699,61.019,382.498-0.035,307.093,0.056    c-57.402,0.069-108.63,36.034-128.194,89.999c-35.029-13.944-74.73,3.148-88.675,38.177c-1.207,3.032-2.195,6.146-2.956,9.319    c-55.932,8.365-94.492,60.488-86.127,116.42c7.502,50.163,50.596,87.275,101.316,87.254h85.333    c9.426,0,17.067-7.641,17.067-17.067c0-9.426-7.641-17.067-17.067-17.067h-85.333c-37.703,0-68.267-30.564-68.267-68.267    s30.564-68.267,68.267-68.267c9.426,0,17.067-7.641,17.067-17.067c0.031-18.851,15.338-34.108,34.189-34.077    c8.915,0.015,17.471,3.517,23.837,9.757c6.713,6.616,17.519,6.537,24.135-0.176c2.484-2.521,4.123-5.751,4.69-9.245    c9.264-55.733,61.954-93.403,117.687-84.139c55.733,9.264,93.403,61.954,84.139,117.687c-0.552,3.323-1.269,6.617-2.146,9.869    c-1.962,7.124,0.883,14.701,7.049,18.773c31.416,20.845,39.985,63.212,19.139,94.628c-12.617,19.015-33.9,30.468-56.72,30.522    h-51.2c-9.426,0-17.067,7.641-17.067,17.067c0,9.426,7.641,17.067,17.067,17.067h51.2    c56.554-0.053,102.357-45.943,102.303-102.497C477.798,208.625,464.526,180.06,441.537,160.625z" fill="#ffffff" data-original="#000000" style="" class=""/>
                                                </g>
                                            </g>
                                            <g xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path d="M353.07,363.292c-6.614-6.387-17.099-6.387-23.712,0l-56.235,56.201V170.558c0-9.426-7.641-17.067-17.067-17.067    c-9.426,0-17.067,7.641-17.067,17.067v248.934l-56.201-56.201c-6.78-6.548-17.584-6.36-24.132,0.419    c-6.388,6.614-6.388,17.099,0,23.713l85.333,85.333c6.656,6.673,17.463,6.687,24.136,0.03c0.01-0.01,0.02-0.02,0.031-0.03    l85.333-85.333C360.038,380.644,359.85,369.84,353.07,363.292z" fill="#ffffff" data-original="#000000" style="" class=""/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <label class="copy-path" for="submit"> Tải xuống </label>
                                    @if ( in_array($file->type, ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'txt', 'TXT', 'flv', 'mp4', 'm3u8', 'ts', '3gp', 'mov', 'avi', 'wmv', 'webm', 'pdf', 'PDF']) )
                                        <a class="preview-file" href="{{route('previewFile', $file->path_download)}}" target="_blank"><i class="fas fa-eye"></i></a>
                                    @endif
                                </div>
                            </div>
                        @else
                        <h3 class="not_exist">Tập tin không tồn tại</h3>
                        @endif
                        <h3 class="not_exist_js" style="display: none">Tập tin không tồn tại</h3>
                        <input type="submit" id="submit" hidden>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#submit").click(function (){
            $('#exists').fadeOut();
            $('.not_exist_js').fadeIn(1500);
    });
</script>
@endsection

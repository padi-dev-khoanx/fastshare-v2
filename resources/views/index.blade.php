<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Fast Share - Chia sẻ nhanh của Khoa</title>
    <link rel="stylesheet" href="{{asset('/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> --}}
    <script type="text/javascript" src="{{asset('/js/dropzone.js')}}"></script>
</head>
<body>
<h1>Fastshare - Chia sẻ file nhanh</h1>
<br>
<section>
    <div class="dropzone" id="my-dropzone" name="myDropzone">
        <div class="dz-message needsclick">
            Thả file vào đây để bắt đầu tải lên.<br>
            <span class="note needsclick">(File tải lên không quá 100MB. Có thể tải
        lên 6 files 1 lúc. File sẽ tự <strong>xoá</strong> sau khi được tải về.)</span>
        </div>
    </div>

</section>

<script type="text/javascript">
    var listId = [];
    var listPath = [];
    Dropzone.options.myDropzone= {
        url: '{{ url('upload_file') }}',
        headers: {
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        },
        autoProcessQueue: true,
        autoQueue: true,
        uploadMultiple: true,
        parallelUploads: 1, //Số file upload song song 1 lúc, vì phía server không xử lý nhận nhiều file 1 lúc nên chỉ upload lần lượt từng file
        maxFiles: 6,
        maxFilesize: 100,
        dictCancelUpload: "<div class=\"text-remove\"> Huỷ tải lên </div>",
        dictUploadCanceled: "<div class=\"text-remove\"> Đã huỷ </div>",
        dictCancelUploadConfirmation: "Bạn chắc chắn muốn huỷ tải lên?",
        dictRemoveFile: "<div class=\"text-remove\" onclick=\" idFile = this.id ;deleteFunction() \"> Xoá </div>",
        dictMaxFilesExceeded: "Bạn chỉ có thể tải lên 6 file.",
        dictFileTooBig: 'File tải lên phải nhỏ hơn 100MB',
        addRemoveLinks: true,
        removedfile: function(file) {
            var name = file.name;
            var _ref;
            if (file.previewElement) {
                if ((_ref = file.previewElement) != null) {
                    _ref.parentNode.removeChild(file.previewElement);
                }
            }
            return this._updateMaxFilesReachedClass();
        },
        previewsContainer: null,
        hiddenInputContainer: "body",
        init: function () {
            this.on("sendingmultiple", function (files, response) {
                window.onbeforeunload = function () {
                    return "";
                };
            });
            this.on("successmultiple", function (files, response) {
                window.onbeforeunload = function () {}
                listId.push(response.id);
                listPath.push(response.path_download);
                $(".text-remove").each(function(index, value){
                    $(this).attr('id', listId[index]);
                })
                $(".dz-details").each(function() {
                    let html_dz_details = $(this).html()
                    //check xem đã có dz-link chưa thì mới chèn thêm
                    if(html_dz_details.search("dz-link") === -1) {
                        $(this).html(html_dz_details + "<div class=\"dz-link\"><span id='dz-link'>" + response.path_download + "</span></div>")
                    }
                })
                $(".dz-preview").each(function() {
                    let html_dz_preview = $(this).html()
                    //check xem đã có dz-link chưa thì mới chèn thêm
                    if(html_dz_preview.search("copy-path") === -1) {
                        $(this).html(html_dz_preview + "<div class=\"copy-path\" data-path=\"" + response.path_download + "\"> Copy url </div>")
                    }
                })
                console.log(response.id)
                console.log(response.path_download)
                // console.log(listPath)
            });
            this.on("canceledmultiple", function (files, response) {
                window.onbeforeunload = function () {}
            });
        },
    }
    function deleteFunction() {
        if(idFile.length != 0) {
            $.ajax({
                type: 'POST',
                url: '{{ url('delete_file') }}',
                headers: {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                data: {
                    "id": idFile
                },
                dataType: 'html'
            });
        }
    }
    $(document).on('click', '.copy-path', function(event) {
        let urlCopy = $(this).data("path")
        let $temp = $("<input>");
        $("body").append($temp);
        $temp.val(urlCopy).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).html("Đã copy")
    });
    // function copyToClipboard(url) {
    //     var $temp = $("<input>");
    //     $("body").append($temp);
    //     $temp.val(url).select();
    //     document.execCommand("copy");
    //     $temp.remove();
    // }
</script>


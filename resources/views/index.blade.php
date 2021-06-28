@extends('layout')
@section('content')
@php
    $typeUser = auth()->user()->type_user ?? 0;
@endphp
    <section>
        <div class="container">
            <div class="dropzone" id="my-dropzone" name="myDropzone">
                <div class="dz-message needsclick">
                    Thả file vào đây để bắt đầu tải lên.<br>
                    @if($typeUser == 1)
                    <span class="note needsclick">(File tải lên không quá 200MB. Có thể tải
        lên 6 files 1 lúc. File sẽ tự <strong>xoá</strong> sau khi hết số lượt tải về hoặc quá 7 ngày.)</span>
                    @else
                    <span class="note needsclick">(File tải lên không quá 100MB. Có thể tải
        lên 6 files 1 lúc. File sẽ tự <strong>xoá</strong> sau khi được tải về hoặc quá 24 giờ.)</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        var listId = [];
        var listPath = [];
        var listIndexError = []; //lưu vị trí file lỗi
        var maxFileSize = 100;
        @if($typeUser == 1)
            maxFileSize = 200;
        @endif

        Dropzone.options.myDropzone = { //lựa chọn options của dropzone
            url: '{{ url('upload_file') }}',
            headers: {
                'X-CSRF-TOKEN': '{!! csrf_token() !!}'
            },
            autoProcessQueue: true,
            autoQueue: true,
            uploadMultiple: true,
            parallelUploads: 1, //Số file upload song song 1 lúc, vì phía server không xử lý nhận nhiều file 1 lúc nên chỉ upload lần lượt từng file
            maxFiles: 6,
            maxFilesize: maxFileSize,
            dictCancelUpload: "<div class=\"text-remove\"> Huỷ tải lên </div>",
            dictUploadCanceled: "<div class=\"text-remove\"> Đã huỷ </div>",
            dictCancelUploadConfirmation: "Bạn chắc chắn muốn huỷ tải lên?",
            dictRemoveFile: "<div class=\"text-remove\" onclick=\" idFile = this.id ;deleteFunction() \"> Xoá </div>",
            dictMaxFilesExceeded: "Bạn chỉ có thể tải lên 6 file.",
            dictFileTooBig: 'File tải lên phải nhỏ hơn ' + maxFileSize + 'MB',
            addRemoveLinks: true,
            timeout: 300000000,
            removedfile: function (file) {
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
                this.on("sendingmultiple", function (files, response) { //trạng thái sending
                    window.onbeforeunload = function () { //ngăn reload
                        return "";
                    };
                    $(".copy-path").each(function () { //ẩn nút copy nếu data rỗng
                        if($(this).data('path') === "none") {
                            $(this).hide()
                        } else {
                            $(this).show()
                        }
                    })
                    $(".dz-link").each(function () {
                        if($(this).html() === "<span></span>" || $(this).html() === "<span>undefined</span>") {
                            $(this).hide()
                        } else {
                            $(this).show()
                        }
                    })
                    $(".times-download").each(function () {
                        if($(this).html() === "" || $(this).html() === "<select class=\"form-select times_download\" name=\"times_download\" id=\"times_download_undefined\" onchange=\"idFile = undefined ;timesDownLoadFunction()\">\n" +
                            "  <option selected=\"\" value=\"1\">1 lần tải</option>\n" +
                            "  <option value=\"2\">2 lần tải</option>\n" +
                            "  <option value=\"3\">3 lần tải</option>\n" +
                            "  <option value=\"4\">4 lần tải</option>\n" +
                            "</select>") {
                            $(this).hide()
                        } else {
                            $(this).show()
                        }
                    })
                });
                this.on("successmultiple", function (files, response) { //trạng thái success
                    window.onbeforeunload = function () {
                    }
                    listId.push(response.id);
                    listPath.push(response.path_download);

                    $(".text-remove").each(function (index, value) { //nút xóa
                        $(this).attr('id', listId[index]);
                    })

                    $(".dz-link").each(function (index, value) {
                        $(this).show()
                        $(this).html("<span>" + listPath[index] + "</span>");
                    })

                    $(".copy-path").each(function (index, value) {
                        $(this).show()
                        $(this).data("path", listPath[index]);
                    })

                    @if($typeUser == 1)
                    $(".times-download").each(function (index, value) {
                        $(this).show()
                        $(this).html("<select class=\"form-select times_download\" name=\"times_download\" id=\'times_download_" + listId[index] + "\' onchange=\'idFile = " + listId[index] + " ;timesDownLoadFunction()\'>\n" +
                            "  <option selected value=\"1\">1 lần tải</option>\n" +
                            "  <option value=\"2\">2 lần tải</option>\n" +
                            "  <option value=\"3\">3 lần tải</option>\n" +
                            "  <option value=\"4\">4 lần tải</option>\n" +
                            "</select>");
                    })
                    @endif
                });
                this.on("canceledmultiple", function (files, response) {
                    window.onbeforeunload = function () {
                    }
                });
                //Check nếu file tải lên thất bại thì sẽ bỏ đi copy và các nút khác
                this.on("error", function (){
                    window.onbeforeunload = function () {
                    }
                    $(".dz-error-message span").each(function (index, value) {
                        if ($(this).html() != "") {
                            listIndexError.push(index)//lưu idex của thẻ html vào để xóa các tính năng dưới
                        }
                    })

                    $(".dz-link").each(function (index, value) {
                        if (listIndexError.includes(index)) {
                            $(this).remove()
                        }
                    })

                    $(".copy-path").each(function (index, value) {
                        if (listIndexError.includes(index)) {
                            $(this).remove()
                        }
                    })

                    $(".times-download").each(function (index, value) {
                        if (listIndexError.includes(index)) {
                            $(this).remove()
                        }
                    })
                })
            },
        }

        function deleteFunction() {
            if (idFile.length != 0) {
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

        function timesDownLoadFunction() {
            //check xem người dùng chọn selected list nào trong timesDownload
            $.ajax({
                type: 'POST',
                url: '{{ url('update_times_download') }}',
                headers: {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                data: {
                    "id": idFile,
                        "times_download": $("#times_download_" + idFile).find(":selected").val(), //chọn value trong times
                },
                dataType: 'html'
            }).done(function() {
                $("#times_download_" + idFile).prop('disabled', true); // ngăn việc chọn lại
            });
        }

        $(document).on('click', '.copy-path', function (event) {
            let urlCopy = $(this).data("path")
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val(urlCopy).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).html("Đã copy")
        });

        $(document).on('click', '.dz-remove', function (event) {
            $(this).parent().remove()
        });
    </script>
@endsection

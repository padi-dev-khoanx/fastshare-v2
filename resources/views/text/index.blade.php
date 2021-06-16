@extends('layout')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <p id="msg" class="error-msg"></p>
                <form class="form" id="textForm" action=" {{ route('text.submit') }}" method="POST">
                    @csrf
                    <label for="title">Title</label>
                    <input id="title" type="text" name="title"/>
                    <label for="summary-ckeditor">Content</label>
                    <textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>
                    <br/>
                    <button type="submit" class="btn btn-primary" style="background: #0087f7">Chia sẻ</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        editor = CKEDITOR.replace('summary-ckeditor');
        $("#textForm").submit(function (event) {
            event.preventDefault();

            let form = $(this),
                title = $("input[name=title]").val(),
                content = editor.getData(),
                url = form.attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    title: title,
                    content: content,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.href = response.text_path;
                    } else {
                        let msg = [];
                        if (response.msg.title) {
                            msg.push(response.msg.title[0]);
                        }
                        if (response.msg.content) {
                            msg.push(response.msg.content[0]);
                        }
                        $('#msg').html(msg.join('<br/>'));
                    }
                },
            });
        });
    </script>
@endsection

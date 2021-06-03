@extends('layout')
@section('content')
<form action=" {{ url('/text/submit') }}" method="POST">
	@csrf
    <label for="title">Title</label>
    <input id="title" type="text" name="title"/>
    <label for="summary-ckeditor">Content</label>
	<textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor' );
</script>
@endsection

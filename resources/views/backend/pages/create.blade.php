@extends('backend.layouts.master')
@section('title','Yeni Səhifə')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            {{$error}}
            @endforeach
        </div>
        @endif
        <form action="{{route('manage.page.post')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Səhifə Başlıq</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Səhifə Rəsm</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Səhifə Məzmun</label>
                <textarea id="editor" name="content" rows="4" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Səhifəni Saxla</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function(){
        $('#editor').summernote(
            {
                height:300
            }
        )
    });
</script>
@endsection
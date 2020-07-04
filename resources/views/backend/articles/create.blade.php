@extends('backend.layouts.master')
@section('title','Yeni Məqalə')
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
        <form action="{{route('manage.meqale.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Məqalə Başlıq</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Məqalə Kateqoriya</label>
                <select name="category" class="form-control" required>
                    <option value="">Seçim Edin</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Məqalə Rəsm</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Məqalə Məzmun</label>
                <textarea id="editor" name="content" rows="4" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Məqaləni Saxla</button>
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
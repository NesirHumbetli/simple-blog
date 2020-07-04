@extends('backend.layouts.master')
@section('title','Parametrler')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{route('manage.config.update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sayt Basliq</label>
                        <input type="text" name="title" required class="form-control" value="{{$config->title}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sayt Status</label>
                        <select name="active" class="form-control">
                            <option @if($config->active == 1) selected @endif value="1">Acik</option>
                            <option @if($config->active == 0) selected @endif value="0">Qapali</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sayt Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sayt Favicon</label>
                        <input type="file" name="favicon" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="facebook" value="{{$config->facebook}}" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Twitter</label>
                        <input type="text" name="twitter" value="{{$config->twitter}}" required class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Github</label>
                        <input type="text" name="github" value="{{$config->github}}" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Linkedin</label>
                        <input type="text" name="linkedin" value="{{$config->linkedin}}" required class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Youtube</label>
                        <input type="text" name="youtube" value="{{$config->youtube}}" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram" value="{{$config->instagram}}" required
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-md btn-success">Redakte</button>
            </div>
        </form>
    </div>
</div>
@endsection
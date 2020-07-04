@extends('backend.layouts.master')
@section('title','Bütün Məqalələr')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$articles->count()}}</strong> məqalə
            mövcuddur.
            <a href="{{route('manage.trashed.article')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i>
                Silinen Meqaleler</a>

        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Rəsm</th>
                        <th>Başlıq</th>
                        <th>Kateqoriya</th>
                        <th>Hit</th>
                        <th>Yazılma Tarixi</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)

                    <tr>
                        <td>
                            <img src="{{asset($article->image)}}" width="200">
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->hit}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td>
                            <input class="switch" data="{{$article->id}}" type="checkbox" data-on="Aktiv"
                                data-off="Deaktiv" data-onstyle="success" data-offstyle="danger"
                                @if($article->status==1) checked @endif
                            data-toggle="toggle">
                        </td>
                        <td>
                            <a target="_blank" href="{{route('single',[$article->getCategory->slug,$article->slug])}}"
                                title="Görüntülə" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            <a href="{{route('manage.meqale.edit',$article->id)}}" title="Redaktə Et"
                                class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                            <a href="{{route('manage.delete.article',$article->id)}}" title="Sil"
                                class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.switch').change(function(){
           var id = $(this).attr('data');
           var status = $(this).prop('checked');
            $.get("{{route('manage.switch')}}",{id:id,status:status}, function(data,status){
                console.log(data);
            });
      });
    });

</script>
@endsection
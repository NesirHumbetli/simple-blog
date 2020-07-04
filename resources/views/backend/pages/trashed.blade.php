@extends('backend.layouts.master')
@section('title','Silinen Məqalələr')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$articles->count()}}</strong> məqalə
            mövcuddur.
            <a href="{{route('manage.meqale.index')}}" class="btn btn-info btn-sm">
                Istifade Olunan Meqaleler</a>

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
                            <a href="{{route('manage.recover.article',$article->id)}}" title="Bərpa Et"
                                class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i></a>
                            <a href="{{route('manage.harddelete.article',$article->id)}}" title="Tam Sil"
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
@extends('backend.layouts.master')
@section('title','Səhifələr')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$pages->count()}}</strong> məqalə
            mövcuddur.
        </h6>
    </div>
    <div class="card-body">
        <div id="orderSuccess" style="display: none;" class="alert alert-success">
            Sıralama Qeyd Olundu
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sıralama</th>
                        <th>Rəsm</th>
                        <th>Başlıq</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    @foreach($pages as $page)

                    <tr id="page_{{$page->id}}">
                        <td width="20" class="handle" style="cursor: move;text-align: center;vertical-align: middle;"><i
                                class="fa fa-arrows-alt-v fa-2x"></i></td>
                        <td>
                            <img src="{{asset($page->image)}}" width="200">
                        </td>
                        <td>{{$page->title}}</td>
                        <td>
                            <input class="switch" data="{{$page->id}}" type="checkbox" data-on="Aktiv"
                                data-off="Deaktiv" data-onstyle="success" data-offstyle="danger" @if($page->status==1)
                            checked @endif
                            data-toggle="toggle">
                        </td>
                        <td>
                            <a target="_blank" href="{{route('page',$page->slug)}}" title="Görüntülə"
                                class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            <a href="{{route('manage.page.edit',$page->id)}}" title="Redaktə Et"
                                class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                            <a href="{{route('manage.page.delete',$page->id)}}" title="Sil"
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
<script>
    $('#orders').sortable({
        handle:'.handle',
        update:function(){
            var row = $('#orders').sortable('serialize');
            $.get("{{route('manage.page.sortable')}}?"+row,function(data,status){
                $('#orderSuccess').show();
                setTimeout(function(){$("#orderSuccess").fadeOut();},1000);
            });
        }

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.switch').change(function(){
           var id = $(this).attr('data');
           var status = $(this).prop('checked');
            $.get("{{route('manage.page.switch')}}",{id:id,status:status}, function(data,status){
                console.log(data);
            });
      });
    });

</script>
@endsection
@extends('backend.layouts.master')
@section('title','Kateqoriyalar')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Kateqoriya</h6>
            </div>
            <div class="card-body">
                <form action="{{route('manage.category.post')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kateqoriya Ad</label>
                        <input type="text" class="form-control" name="category" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Elave Et</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kateqoriya Ad</th>
                                <th>Məqalə Sayı</th>
                                <th>Status</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)

                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td>
                                    <input class="switch" data="{{$category->id}}" type="checkbox" data-on="Aktiv"
                                        data-off="Deaktiv" data-onstyle="success" data-offstyle="danger"
                                        @if($category->status==1) checked @endif
                                    data-toggle="toggle">
                                </td>
                                <td>
                                    <a category-id="{{$category->id}}" title="Redaktə"
                                        class="btn btn-sm btn-primary edit-click"><i
                                            class="fa fa-edit text-white"></i></a>
                                    <a category-id="{{$category->id}}" category-count="{{$category->articleCount()}}"
                                        category-name="{{$category->name}}" title="Sil"
                                        class="btn btn-sm btn-danger remove-click"><i
                                            class="fa fa-times text-white"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kateqoriya Redaktə</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('manage.category.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kateqoriya Ad</label>
                        <input id="category" type="text" name="category" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kateqoriya Slug</label>
                        <input id="slug" type="text" name="slug" class="form-control">
                    </div>
                    <input type="hidden" name="id" id="category_id">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Çıxış</button>
                <button type="submit" class="btn btn-success">Saxla</button>
            </div>
            </form>

        </div>
    </div>
</div>
<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kateqoriya Sil</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="body" class="modal-body">
                <div class="alert alert-danger" id="articleAlert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Çıxış</button>
                <form action="{{route('manage.category.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="deleteId">
                    <button id="deleteBtn" type="submit" class="btn btn-success">Sil</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit-click').click(function(){
            id = $(this).attr('category-id');
            $.ajax({
                type:'GET',
                data:{id:id},
                url:'{{route('manage.category.getdata')}}',
                success:function(data){
                    console.log(data);
                    $('#editModal').modal();
                    $('#category').val(data.name);
                    $('#slug').val(data.slug);
                    $('#category_id').val(data.id);
                }
            });
        });

        $('.remove-click').click(function(){
            id = $(this).attr('category-id');
            count = $(this).attr('category-count');
            name = $(this).attr('category-name');
            if(id==1){
                $('#articleAlert').html(name+' Kateqoriya sabitdir. Silinən digər kateqoriyalara aid məqalələr bura elave edilecek.');
                $('#body').show();
                $('#deleteBtn').hide();
                $('#deleteModal').modal();
                return;
            }
            $('#deleteBtn').show();
            $('#deleteId').val(id);
            $('#articleAlert').html('');
            $('#body').hide();
            if(count>0){
                $('#articleAlert').html('Seçilən Kateqoriyaya aid: '+count+' məqalə mövcuddur. Silmək istədiyinizə əminsiniz?');
                $('#body').show();
            }
            $('#deleteModal').modal();
        });


        $('.switch').change(function(){
            id = $(this).attr('data');
            status = $(this).prop('checked');
            $.get("{{route('manage.category.switch')}}",{id:id,status:status},function(data,status){});
        });

    });
</script>
@endsection
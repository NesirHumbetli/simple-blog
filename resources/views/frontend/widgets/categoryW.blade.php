@isset($categories)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Kateqoriyalar
        </div>
        @foreach($categories as $category)
        <li class="list-group-item @if(Request::segment(2) == $category->slug) active @endif">
            <a @if(Request::segment(2) !=$category->slug)href="{{route('category',$category->slug)}}"@endif>
                {{$category->name}}
                <small class="badge badge-success float-right">{{$category->articleCount()}}</small>
            </a>
        </li>
        @endforeach
    </div>
</div>
@endisset
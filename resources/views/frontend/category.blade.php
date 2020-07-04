@extends('frontend.layouts.master')
@section('title',$category->name.' Kateqoriyası')
@section('content')
<div class="col-md-9 mx-auto">
  @include('frontend.widgets.articleList')
</div>
@include('frontend.widgets.categoryW')
@endsection
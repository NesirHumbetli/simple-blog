@extends('frontend.layouts.master')
@section('title','Bloq Saytı')
@section('content')
<div class="col-lg-9 col-md-10 mx-auto">
  @include('frontend.widgets.articleList')
</div>
@include('frontend.widgets.categoryW')
@endsection
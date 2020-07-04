@extends('frontend.layouts.master')
@section('title',$article->title)
@section('bg',$article->image)
@section('content')
<div class="col-md-9 mx-auto">
  {!!$article->content!!}
  <div><span class="text-info">Oxunma sayısı : <b>{{$article->hit}}</b></span></div>
</div>
@include('frontend.widgets.categoryW')
@endsection
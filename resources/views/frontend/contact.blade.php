@extends('frontend.layouts.master')
@section('title','Elaqe')
@section('bg','https://www.whiteriver.org/wp-content/uploads/2018/10/ContactUsHeader.jpg')
@section('content')
<div class="col-md-8 mx-auto">
  @if(session('success'))
  <div class="alert alert-success">
    {{session('success')}}
  </div>
  @endif
  @if($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <p>Bizimlə Əlaqə Qura Bilərsiniz!
  </p>
  <form method="POST" action="{{route('contact.post')}}">
    @csrf
    <div class="control-group">
      <div class="form-group controls">
        <label>Ad Soyad</label>
        <input type="text" class="form-control" value="{{old('name')}}" placeholder="Ad və Soyadınız" name="name"
          required>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group controls">
        <label>Elektron Poçt</label>
        <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Address" name="email"
          required>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group col-xs-12 controls">
        <label>Mövzu</label>
        <select name="topic" class="form-control">
          <option @if(old('topic')=='Məlumat' ) selected @endif>Məlumat</option>
          <option @if(old('topic')=='Dəstək' ) selected @endif>Dəstək</option>
          <option @if(old('topic')=='Ümumi' ) selected @endif>Ümumi</option>
        </select>
      </div>
    </div>
    <div class="control-group">
      <div class="form-group controls">
        <label>Mesajınız</label>
        <textarea rows="5" class="form-control" placeholder="Mesajınız" name="message">{{old('message')}}</textarea>
      </div>
    </div>
    <br>
    <div id="success"></div>
    <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
  </form>
</div>
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      Elaqe Melumatları
    </div>
    <div class="card-body">

    </div>
  </div>
</div>
@endsection
@extends('layouts.user')

@section('title_page', Str::title($item->title))

@section('header')
<header class="masthead">
  <div class="overlay"></div>
  <div class="container">
    <div class="row" style="min-height: 9.7vh">
      <div class="col-lg col-md-10 mx-auto">

      </div>
    </div>
  </div>
</header>
@endsection

@section('content')
  <div class="card p-0 shadow-sm border-0">
    <img class="card-img-top img-fluid rounded" src="../{{$item->cover}}" alt="" srcset="">
    <div class="card-body">
      <h1>{{ Str::title($item->title) }}</h1>
        <i class="fa fa-calendar"></i>
        {{ $item->created_at->format('F d, Y') }} 
        <br/>
        <i class="fa fa-tag" aria-hidden="true"></i>
        {{ $item->category->name }}
    </div>
    <div class="card-body" id="content">
      {!! $item->content !!}
    </div>
    <div class="card-body">
      @foreach ($item->Review as $key => $value)
        <div class="row">
          <div class="col" style="font-weight: 500">
            {{ $value->user->name }}
          </div>
          <div class="col text-right">
            {{ $value->created_at->format('F d, Y') }}
          </div>
        </div>
        <div style="margin:  1vh 0 5vh 0">
          {{ strip_tags($value->content) }}
          @auth
            @if (Auth::user()->id == $value->user_id)
              <a href="" class="komentar"> <u>Hapus</u> </a>
            @endif
          @endauth
        </div>
      @endforeach

    </div>    
    @guest
    <div class="card-body">
      Silahkan <u>Login</u> ! untuk dapat komentar
    </div>
    <div class="card-body">
      <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
      <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
    </div>
    @else
      <div class="card-body">
        <form action="" id="formKomentar">
          @csrf
          <input type="text" name="article_id" id="article_id" value="{{ $item->id }}" hidden>
          <input type="text" name="category" id="category" class="form-control" placeholder="" aria-describedby="helpId" value="Komentar" hidden>
          <input type="number" name="user_id" id="user_id" class="form-control" placeholder="" aria-describedby="helpId" value="{{ Auth::user()->id }}" hidden>

          <div class="row">
            <div class="form-group col">
              <label for="">Nama</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="" aria-describedby="helpId" value="{{ Auth::user()->name }}" disabled>
            </div>
    
            <div class="form-group col">
              <label for="">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId" value="{{ Auth::user()->email }}" disabled>
            </div>  
          </div>
          
          <div class="form-group">
            <label for="">Kritik dan Saran</label>
            <textarea class="form-control" name="content" id="content" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Komentari</button>
        </form>
      </div>
    @endguest
  </div>
@endsection

@push('styles')
<style>
  body {
    background-color: white
  }

  /* #ini_content {
    top: -155px;
    position: relative;
  } */

.card-body {
    font-size: 13pt;
    font-family: Arial, Helvetica, sans-serif
    /* text-align: justify; */
  }
</style>
@endpush

@push('scripts')
<script>
  $('#content').find('p').removeAttr('style');
  $('#content').find('img').toggleClass('note-float-right rounded img-fluid').removeAttr('style');
  
  $('#formKomentar').on('submit', function (e) {
    e.preventDefault()

    var data = $('#formKomentar').serialize()
    
    $.ajax({
      type: "POST",
      url: "{{ route('reviews.store') }}",
      data: data,
      success: function (response) {
        $('#formKomentar').trigger('reset');
        alert(response.status)
        location.reload(true)
      },
      error: function (xhr) {
        $.each(xhr.responseJSON.errors, function (index, value) { 
          alert(value[0])
        });
      }
    });
  });
</script>
@endpush

@extends('layouts.user')

@section('title_page', Str::title($item->title))

@section('header')
<header class="masthead" style="background-color: #32373D">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg col-md-10 mx-auto">
        <div class="post-heading">
          <h1>{{ Str::title($item->title) }}</h1>
          <span class="meta">
            <p>
              {{ $item->created_at->format('F d, Y') }} <br/>{{ $item->category}}</a>
            </p>
          </span>
        </div>
      </div>
    </div>
  </div>
</header>
@endsection

@section('content')
  <div class="card mb-4 p-0 border-0 shadow-sm">
    <div class="card-body">
        <img class="img-fluid rounded" src="../{{$item->cover}}" alt="" srcset="">
    </div>
    <div class="card-body" id="content">
      {!! $item->content !!}
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <h2 class="card-title">
        <i class="fa fa-comments" aria-hidden="true"></i>
        {{ count($item->Review) }} Diskusi
      </h2>
    </div>
    <ul class="list-group list-group-flush">
      @foreach ($item->Review as $key => $value)
      <li class="list-group-item">
        <h3>
          <i class="fas fa-person-booth"></i>
          {{ $value->user->name }}</h3>
        <span class="badge badge-light"><i class="fas fa-calendar-alt"></i> {{ $value->created_at->format('F d, Y') }}</span>
        <p>
          {{ strip_tags($value->content) }}
          @auth
          @if (Auth::user()->id == $value->user_id)
          <a href="" class="komentar">
            <i class="fas fa-trash-alt    "></i>
          </a>
          @endif
          @endauth
        </p>
      </li>
      @endforeach
    </ul>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h2 class="card-title">
        Tulis Komentar
        <i class="fas fa-comment"></i>
      </h2>
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

  #ini_content {
    top: -155px;
    position: relative;
  }

#content {
    font-size: 12pt;
    text-align: justify;
  }

  .masthead {
    background: linear-gradient(87deg,#5e72e4,#825ee4)!important;
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
      url: "{{ route('review') }}",
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

@extends('layouts.user')

@section('title_page', 'Artikel')

@section('header')
<header class="masthead">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg col-md-10 mx-auto">
        <div class="post-heading">
          <h1>{{ Str::title(Str::after(URL::current(), env('APP_URL'))) }}</h1>
        </div>
      </div>
    </div>
  </div>
</header>
@endsection

@section('content')
<div class="row">
  @foreach ($articles as $item)
    @include('include.articles')
  @endforeach
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="vendor/swiper.min.css">
<style>
  body {background-color: white}
</style>
@endpush

@push('scripts')
  <script src="vendor/swiper.min.js"></script>
  <script src="vendor/holder.js"></script>
  <script>
  $(document).ready(function () {
    
    // gallery
    $('.parent-container').magnificPopup({
      delegate: 'img',
      type: 'image',
      gallery:{
        enabled:true
      }
    });

    // swi
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  });
  </script>
@endpush
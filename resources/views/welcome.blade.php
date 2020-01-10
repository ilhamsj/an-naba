@extends('layouts.user')

@section('title_page', env('APP_MOTTO'))

@section('header')
<header class="masthead">
  <div class="overlay"></div>
  <div class="swiper-container">
    <div class="swiper-wrapper">
      @foreach ($slider as $item)
      @if (env('APP_ENV') == 'local')
      <div class="swiper-slide text-center">
        <img class="img-fluid" data-src="holder.js/1366x568?auto=yes&random=yes&size=20&text=Coding Bootcamp" alt="" srcset="">
      </div>
      @else
      <div class="swiper-slide text-center" style="max-height:70vh">
        <img class="img-fluid" src="{{$item->file}}" alt="" srcset="">
      </div>
      @endif
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
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
<link rel="stylesheet" href="{{ secure_url('vendor/swiper.min.css') }}">
<style>
  body {
    background-color: white
  }
</style>
@endpush

@push('scripts')
<script src="{{ secure_url('vendor/swiper.min.js') }}"></script>
<script src="{{ secure_url('vendor/holder.js') }}"></script>
<script>
  $(document).ready(function() {

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
    });
  });
</script>
@endpush
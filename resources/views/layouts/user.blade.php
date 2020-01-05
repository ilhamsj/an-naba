<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="google-site-verification" content="{{ env('GOOGLE_VERIVICATION')}}" />
  <title>@yield('title_page') | {{ env('APP_NAME') }}</title>
  <link href='{{ secure_url('vendor/Lora.css') }}' rel='stylesheet' type='text/css'>
  <link href='{{ secure_url('vendor/Open-Sans.css') }}' rel='stylesheet' type='text/css'>
  <link href='{{ secure_url('vendor/holder.js') }}' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ secure_url('css/app.css') }}">
  <style>
    .whatsapp {
      bottom: 0;
      right: 50px;
    }
    * {
      font-family: 'Poppins'
    }

  .masthead {
    background: linear-gradient(90deg, #A34B7D, #50816E, #6FBEBE)!important;
  }
  </style>
  @stack('styles')
</head>

<body>
    @php
        $sosmed = [
          'twitter' => [
            'icon' => 'fab fa-twitter fa-stack-1x fa-inverse',
            'url'   => '#'
          ],
          'facebook' => [
            'icon' => 'fab fa-facebook-f fa-stack-1x fa-inverse',
            'url'   => '#'
          ],
          'instagram' => [
            'icon' => 'fab fa-instagram fa-stack-1x fa-inverse',
            'url'   => '#'
          ],
        ];

        $menu = [
          'Home' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('welcome'),
          ],
          'Blog' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('user.artikel.index'),
          ],
          'Kegiatan' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => '#',
          ],
          'Kontak' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('user.artikel.show', 'kontak'),
          ],
        ];
    @endphp

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="{{ env('APP_URL') }}"> {{ env('APP_NAME') }}</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          @foreach ($menu as $key => $val)
          <li class="nav-item">
            <a class="nav-link {{ $val['link'] == URL::current() ? '' : '' }}" href="{{ $val['link'] }}">
            {!! $val['link'] == URL::current() ? '<i class="fa fa-circle"></i>' : '' !!} {{ $key }}
            </a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </nav>

  @yield('header')

  <div class="container" style="margin: 10vh auto">
    <div class="row">
      <div class="col-12 col-sm-9" id="ini_content">
        @yield('content')
      </div>
      <div class="col">
        <div class="card mb-4 border-0">
          <ul class="list-group list-group-flush">
            @foreach ($news as $item)
              <li class="list-group-item px-0 mb-1" style="font-size: medium">
                <img src="{{ secure_url($item->cover) }}" class="rounded" style="max-height: 70px" alt="" srcset=""> <br/>
                <span class="" style="font-size: small">{{ $item->created_at->format('d F Y') }}</span> <br/>
                <a class="" style="font-weight: 500" href="{{ strip_tags(route('user.artikel.show', $item->slug)) }}">{{ $item->title }}</a> <br/>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
  @yield('gallery')
  
  @php
      $footer = [
        env('APP_NAME') => [
          env('APP_MOTTO') => '#',
        ],
        'Peta Situs' => [
          'Blog'       => route('user.artikel.index'),
          'Dokumen'      => route('user.artikel.index'),
          'Kategori'      => route('user.artikel.index'),
          'Review'      => route('user.artikel.index'),
          'Sitemap'      => route('sitemap.index'),
        ],
        'Gabung' => [
          'Grup Facebook' => route('user.artikel.index'),
          'Grup Telegram'      => route('user.artikel.index'),
        ],
      ];
  @endphp
  <!-- Footer -->
  <footer style="background-color: #00428A" class="text-light">
    <div class="container">
      <div class="row justify-content-center">
        @foreach ($footer as $key => $val)
          <div class="col-6 col-md mb-4" id="{{ Str::slug($key) }}">
            <h4>{!! strtoupper($key) !!}</h4>
            @if (is_array($val))
            <ul class="nav flex-column">
                @foreach ($val as $k => $v)
                  <li class="nav-item">
                    <a href="{{ $v }}" target="_blank" class="nav-link text-light pl-0">{!! $k !!}</a>
                  </li>
                @endforeach
            </ul>
            @else
                {{ $val }}
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </footer>  
  <footer style="background-color: #00428A" class="text-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <a href="" class="text-light">
            {{-- <i class="fa fa-copyright" aria-hidden="true"></i> {{ env('APP_NAME')  . date(' Y')}} --}}
            Made with <i class="fa fa-heartbeat" aria-hidden="true"></i> in Yogyakarta, Indonesia
          </a>
        </div>
      </div>
    </div>
  </footer>  
  <section class="whatsapp position-fixed rounded-left" id="saran">
      <a href="" class="btn btn-primary rounded-top">Contact Us</a>
  </section>

  <script src="{{ secure_url('js/app.js') }}"></script>
  <script>
  $(document).ready(function () {


    $(window).on('resize', function () {
      var getSize = $(this);
      responsiveX(getSize.width())
    });

    responsiveX($(window).width())

    function responsiveX(widthSize) {
      if(widthSize < 576) {
        console.log(widthSize);
        $('#mainNav').css('position', 'relative');
      } else {
        $('#mainNav').css('position', 'absolute');
      }
    }

    $('footer').first().find('.col-6:first-child').toggleClass('col-md col-md-7')

  });

  </script>
  @stack('scripts')
</body>

</html>

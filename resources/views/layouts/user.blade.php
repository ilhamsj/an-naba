<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="google-site-verification" content="X992wX_b2CEsO4oVmh2PPo53029pbnXqtsZ8345KN14" />
  <title>@yield('title_page') | {{ env('APP_NAME') }}</title>
  <link href='{{ secure_url('vendor/Lora.css') }}' rel='stylesheet' type='text/css'>
  <link href='{{ secure_url('vendor/Open-Sans.css') }}' rel='stylesheet' type='text/css'>
  <link href='{{ secure_url('vendor/holder.js') }}' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ secure_url('css/app.css') }}">
  <style>
    .whatsapp {
      bottom: 0;
      right: 100px;
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
          'Profil' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('user.artikel.show', 'tentang-kami'),
          ],
          'Kegiatan' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('user.kegiatan.index'),
          ],
          'Kontak' => [
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'link'  => route('user.artikel.show', 'kontak'),
          ],
        ];
    @endphp

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
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
              <li class="list-group-item px-0 mb-1">
                <span class="" style="font-size: small">{{ $item->created_at->format('d F Y') }}</span> <br/>
                <a href="{{ route('user.artikel.show', $item->slug) }}">{{ $item->title }}</a> <br/>
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
        env('APP_NAME') => 
        [
          'Made with love in Yogyakarta' => '',
        ],
        'Peta Situs' => [
          'Artikel'        => route('user.artikel.index'),
          'Kegiatan'    => route('user.kegiatan.index'),
          'Pengumuman'  => route('user.pengumuman.index'),
          'Dokumen'     => route('user.dokumen.index'),
        ],
        'Ikuti '. env('APP_NAME') => [
          'Facebook'        => route('user.artikel.index'),
          'Instagram'    => route('user.kegiatan.index'),
        ],
        'Gabung' => [
          'Grub Facebook'        => route('user.artikel.index'),
          'Telegram'        => route('user.artikel.index'),
        ],
      ];
  @endphp
  <!-- Footer -->
  <footer style="background-color: #1b4b72" class="text-light">
    <div class="container">
      <div class="row justify-content-center">
        @foreach ($footer as $key => $val)
          <div class="col" id="{{ Str::slug($key) }}">
            <h4>{!! strtoupper($key) !!}</h4>
            @if (is_array($val))
            <ul class="nav flex-column">
                @foreach ($val as $k => $v)
                  <li class="nav-item">
                    <a href="{{ $v }}" class="nav-link text-light pl-0">{!! $k !!}</a>
                  </li>
                @endforeach
            </ul>
            @else
                {{ $val }}
            @endif
          </div>
        @endforeach
        <div class="col-12 mt-4">
          <i class="fa fa-copyright" aria-hidden="true"></i> {{ env('APP_NAME')  . date(' Y')}}
        </div>
      </div>
    </div>
  </footer>  
  <section class="whatsapp position-fixed rounded-left" id="saran">
      <a href="" class="btn btn-primary rounded-top">Kritik Saran</a>
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

    $('#laravel').toggleClass('col col-5')

  });

  </script>
  @stack('scripts')
</body>

</html>

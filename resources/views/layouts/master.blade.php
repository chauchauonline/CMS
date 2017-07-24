<!DOCTYPE html>
<html lang="vi-vn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="description description description description description description description description description">
  <meta name="keywords" content="keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>@yield('title')</title>
  <!-- Style - Libs -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/swiper.min.css') }}">
  <!-- My Style -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/subpage.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}">
</head>
<body>
    <!-- Begin Header -->
    @include('partial.header')
    <!-- End Header -->

    @yield('content')

    <!-- Begin Footer -->
    @include('partial.footer')
    <!-- End Footer -->
      <a href="" class="backtotop"><img src="{{asset('/img/backtotop.png')}}" alt="Back to top"></a>

      <!-- Java Scripts - Libs -->
      <script type="text/javascript" src="{{ asset('/js/jquery.min.1.11.1.js') }}"></script>

      <!--[if lt IE 9]>
        <script src="{{ asset('/js/html5shiv.js') }}"></script>
      <![endif]-->

    <script type="text/javascript" src="{{ asset('/js/css_browser_selector.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/slideall.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/swiper.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.jcarousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jcarousel.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.colorbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/slick.js') }}"></script>
    <script type="text/javascript">
        baseUrl = "{{URL::to('/')}}";
    </script>
    <script type="text/javascript" src="{{ asset('/js/scripts.js') }}"></script>
</body>
</html>

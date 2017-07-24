<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> @yield('title') </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/cms/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('/cms/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Endless -->
    <link href="{{ asset('/cms/css/endless.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="text-center">
            <a href="{{Route('site.index')}}" class="logo pleft">
                <img src="{{ Image::url('/img/vbn-logo.png',210,100,array('crop')) }}" alt="vbn.org.vn">
            </a>
        </div>
         <div class="login-widget animation-delay1">
            <div class="panel panel-default">
                <div>
                    <p class="col-sm-7 text-center text-success">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                                <strong>  {{ $message }} </strong>
                            </div>
                        @endif
                    </p>
                </div>
                @yield('content')
            </div>
        </div>
	</div><!-- /login-wrapper -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- Jquery -->
    <script src="{{ asset('/cms/js/jquery-1.10.2.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('/cms/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Modernizr -->
    <script src="{{ asset('/cms/js/modernizr.min.js') }}"></script>

    <!-- Pace -->
    <script src="{{ asset('/cms/js/pace.min.js') }}"></script>

    <!-- Popup Overlay -->
    <script src="{{ asset('/cms/js/jquery.popupoverlay.min.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('/cms/js/jquery.slimscroll.min.js') }}"></script>

    <!-- Cookie -->
    <script src="{{ asset('/cms/js/jquery.cookie.min.js') }}"></script>

    <!-- Endless -->
    <script src="{{ asset('/cms/js/endless/endless.js') }}"></script>
    @yield('script')
</body>
</html>

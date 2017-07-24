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

    <!-- Pace -->
    <link href="{{ asset('/cms/css/pace.css') }}" rel="stylesheet">

    <!-- Endless -->
    <link href="{{ asset('/cms/css/endless.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/css/endless-skin.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/css/dashboad-new.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/css/custom.css') }}" rel="stylesheet">

</head>
<body class="overflow-hidden">
<div id="wrapper" class="preload">
    @include('cms::partial.header');
    @include('cms::partial.sidebar');
    <div id="main-container">
        <div id="breadcrumb">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="/"> Trang chủ</a></li>
                <li class="active">@yield('breadcrumbs')</li>
        </ul>
    </div><!-- breadcrumb -->
    <div class="padding-md">
        @if ($errors->any())
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                @if ($message = $errors->first(0, ':message'))
                     {{ $message }}
                @else
                    Đã xảy ra lỗi!
                @endif
            </div>
        @endif

        @if ($message = Session::get('success'))
       	    <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
                <strong>  {{ $message }} </strong>
            </div>
        @endif

        @yield('content')
        </div><!-- /padding-md -->
    </div><!-- /main-container -->
</div>

<!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
    crossorigin="anonymous"></script>

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
    <!-- Ckeditor -->

    <script type="text/javascript">
        baseUrl = "{{URL::to('/')}}";
        roxyFileman = '/cms/fileman/index.html?integration=ckeditor';
        options = {
                removeDialogTabs: 'link:upload;image:Upload',
                filebrowserBrowseUrl:roxyFileman,
                filebrowserUploadUrl:roxyFileman,
                filebrowserImageBrowseUrl:roxyFileman+'&type=image'};
    </script>
    <script src="{{ asset('/cms/ckeditor/ckeditor.js') }}"></script>
    @yield('script')
</body>
</html>
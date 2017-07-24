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
    <link href="{{ asset('/cms/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/css/dashboad-new.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('/cms/datepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">

</head>
<body class="overflow-hidden">
    <!-- Overlay Div -->
    <div id="overlay" class="transparent"></div>

    <div id="wrapper" class="preload">

        @include('cms::partial.header');
        <?php $user = Sentinel::getUser(); ?>
        @if($user->inRole('admin'))
            @include('cms::partial.sidebar');
        @endif
        <div id="main-container">
        <div id="breadcrumb">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="http://{{Config::get('constants.FRONT_END')}}"> Trang chủ</a></li>
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
    <a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>
    @yield('modal')
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
    <!-- Endless -->
    <script src="{{ asset('/cms/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/cms/js/endless/endless_custom.js') }}"></script>
    <script src="{{ asset('/cms/js/endless/endless.js') }}"></script>

    <script src="{{ asset('/cms/datepicker/js/moment.js') }}"></script>
    <script src="{{ asset('/cms/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>
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

@extends('cms::layouts.cms')

@section('title', 'Thay đổi ảnh của trang')
@section('breadcrumbs', 'Thay đổi ảnh của trang')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Thay đổi ảnh của trang</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        <div class="row text-center">
            <?php $image = Modules\Cms\Entities\Image::find($page->image_id); ?>
            @if(!$image)
                <img src="" style="width:336px; height:200px" alt="Ảnh trang">
            @else
                <img src="{{$image->thumbs}}" alt="Ảnh trang" style="width:336px;">
            @endif
        </div>
        <br><hr>

        {!! Form::open(['method'=>'POST', 'route' => 'pages.upload',  'class' => 'form-horizontal', 'files'=> true]) !!}
            {!! Form::hidden('page_id', $page->id)!!}
            <div class="row text-center">
<!--                 <label class="col-sm-1 col-sm-offset-4">Chọn ảnh khác:</label><br> -->
                <div class="col-sm-offset-4  text-center">
                    {!! Form::file('image') !!}
                    <p class='text-danger'>{{ ($errors->has('photo') ? $errors->first('photo') : '') }}</p>
                </div>
            </div>
            <br>
            <div class="row text-center">
                <div class= 'col-sm-1  col-sm-offset-6'>
                    <button type="submit" class="btn btn-success btn-sm bounceIn"><i class="fa fa-upload">Lưu ảnh </i></button>
                </div>
                <div class="col-sm-1">
                    <a href="{{ URL::to('pages')}}" class="btn btn-danger btn-sm bounceIn" role="button">Quay lại</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
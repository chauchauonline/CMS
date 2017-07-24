@extends('cms::layouts.cms')

@section('title', 'Tạo trang mới')
@section('breadcrumbs', 'Tạo trang mới')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Tạo trang mới</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        {!! Form::open(['route' => 'pages.store', 'class' => 'form-horizontal', 'files' => 'true']) !!}
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Tên trang:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('name') ? $errors->first('name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('slug')) ? 'has-error' : '' }}">
                <label for="slug" class="col-sm-2 control-label">Slug:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('slug', null, ['class'=>'form-control', 'id' => 'slug']) !!}
                    <p class='help-block'>{{ ($errors->has('slug') ? $errors->first('slug') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('upload_folder')) ? 'has-error' : '' }}">
                {!! Form::label('upload_folder', 'Thư mục uploads:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('upload_folder', null, ['class'=>'form-control', 'id' => 'upload_folder', 'readonly']) !!}
                    <p class='help-block'>{{ ($errors->has('upload_folder') ? $errors->first('upload_folder') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('order')) ? 'has-error' : '' }}">
                {!! Form::label('order', 'Sắp xếp:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('order', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('order') ? $errors->first('order') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('banner')) ? 'has-error' : '' }}">
                {!! Form::label('banner', 'Banner:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('banner', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('banner') ? $errors->first('banner') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('view')) ? 'has-error' : '' }}">
                {!! Form::label('view', 'View:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('view', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('view') ? $errors->first('banner') : '') }}</p>
                </div>
            </div>

            {!! Form::hidden('compiler', 'blade')!!}

            <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">
                {!! Form::label('status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    @foreach ($page_status as $key=>$status)
                        @if($key == 1)
                            <label class="radio-inline">
                            {!! Form::radio('status', $key, true) !!} {{ $status }}
                            </label>
                        @else
                            <label class="radio-inline">
                            {!! Form::radio('status', $key) !!} {{ $status }}
                            </label>
                        @endif
                    @endforeach
                    <p class='help-block'>{{ ($errors->has('status') ? $errors->first('status') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('heading')) ? 'has-error' : '' }}">
                {!! Form::label('heading', 'Heading:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('heading', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('heading') ? $errors->first('heading') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Title:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('title') ? $errors->first('title') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
                <label for="content" class="col-sm-2 control-label">Nội dung:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::textarea('content', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('content') ? $errors->first('content') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('keyword')) ? 'has-error' : '' }}">
                <label for="keyword" class="col-sm-2 control-label">Từ khóa:</label>
                <div class="col-sm-10">
                {!! Form::text('keyword', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('keyword') ? $errors->first('keyword') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('description')) ? 'has-error' : '' }}">
                <label for="description" class="col-sm-2 control-label">Mô tả:</label>
                <div class="col-sm-10">
                {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('description') ? $errors->first('description') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('image')) ? 'has-error' : '' }}">
                <label for="image" class="col-sm-2 control-label">Ảnh:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::file('image',null) !!}
                <p class='help-block'>{{ ($errors->has('image') ? $errors->first('image') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('abstract')) ? 'has-error' : '' }}">
                <label for="abstract" class="col-sm-2 control-label">Tóm tắt:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::textarea('abstract', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('abstract') ? $errors->first('abstract') : '') }}</p>
                </div>
            </div>

            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm bounceIn ">Lưu lại</button>
                <a href="{{ route('pages.index') }}" class="btn btn-danger btn-sm bounceIn " role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
<script type="text/javascript">
    $(function(){
        CKEDITOR.replace( 'content', options);
    });

    $('#slug').keyup(function(){
        var slug = $(this).val();
        console.log(slug);
        $('#upload_folder').val("uploads/pages/"+slug);
    });
</script>
@stop

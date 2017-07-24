@extends('cms::layouts.cms')

@section('title', 'Chỉnh sửa trang')
@section('breadcrumbs', 'Chỉnh sửa trang')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Chỉnh sửa trang</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        {!! Form::model($page,['method' => 'PATCH','route'=>['pages.update' , $page->id], 'class' => 'form-horizontal']) !!}
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Tên trang:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('name', $page->name, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('name') ? $errors->first('name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('slug')) ? 'has-error' : '' }}">
                <label for="slug" class="col-sm-2 control-label">Slug:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('slug', $page->slug, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('slug') ? $errors->first('slug') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('upload_folder')) ? 'has-error' : '' }}">
                {!! Form::label('upload_folder', 'Thư mục uploads:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('upload_folder', $page->upload_folder, ['class'=>'form-control', 'readonly']) !!}
                    <p class='help-block'>{{ ($errors->has('upload_folder') ? $errors->first('upload_folder') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('order')) ? 'has-error' : '' }}">
                {!! Form::label('order', 'Sắp xếp:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('order', $page->order, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('order') ? $errors->first('order') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('banner')) ? 'has-error' : '' }}">
                {!! Form::label('banner', 'Banner:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('banner', $page->banner, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('banner') ? $errors->first('banner') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('view')) ? 'has-error' : '' }}">
                {!! Form::label('view', 'View:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('view', $page->view, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('view') ? $errors->first('banner') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">
                {!! Form::label('status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    @foreach ($page_status as $key=>$status)
                        @if($key == $page->status)
                            <label class="radio-inline">
                            {!! Form::radio('status', $key, true) !!} {{ $status }}
                            </label>
                        @elseif($key == 1)
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
                    {!! Form::text('heading', $page->heading, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('heading') ? $errors->first('heading') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Title:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::text('title', $page->title, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('title') ? $errors->first('title') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
                <label for="content" class="col-sm-2 control-label">Nội dung:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::textarea('content', $page->content, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('content') ? $errors->first('content') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('keyword')) ? 'has-error' : '' }}">
                <label for="keyword" class="col-sm-2 control-label">Từ khóa:</label>
                <div class="col-sm-10">
                {!! Form::text('keyword', $page->keyword, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('keyword') ? $errors->first('keyword') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('description')) ? 'has-error' : '' }}">
                <label for="description" class="col-sm-2 control-label">Mô tả:</label>
                <div class="col-sm-10">
                {!! Form::textarea('description', $page->description, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('description') ? $errors->first('description') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('abstract')) ? 'has-error' : '' }}">
                <label for="abstract" class="col-sm-2 control-label">Tóm tắt:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                {!! Form::textarea('abstract', $page->abstract, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('abstract') ? $errors->first('abstract') : '') }}</p>
                </div>
            </div>

            <div class="pull-right">
                <button type="submit" class=" btn btn-success btn-sm bounceIn">Lưu lại</button>
                <a href="{{ URL::to('pages')}}" class=" btn btn-danger btn-sm bounceIn" role="button">Hủy</a>
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
</script>
@stop

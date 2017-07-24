@extends('cms::layouts.cms')

@section('title','Bài Viết')
@section('breadcrumbs','Bài Viết')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Bài Viết: {{$article->title}}</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
            {!! Form::open(['class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('title', 'Tiêu đề:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('title',$article->title,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('brief', 'Tóm tắt:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('brief',$article->brief,['class'=>'form-control','rows'=>3, 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Danh mục:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('category_id',$cates['name'],['class'=>'form-control', 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('content', 'Nội dung:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('content',$article->content,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('source', 'Nguồn:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('source',$article->source,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('orderby', 'Thứ tự:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('orderby',$article->orderby,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group {{ ($errors->has('user_id')) ? 'has-error' : '' }}">
                <label for="orderby" class="col-sm-2 control-label">Tác giả</label>
                <div class="col-sm-10">
                    {!! Form::text('user_id',$user["id"],['class'=>'form-control','readonly']) !!}
                    <p class="help-block">{{ ($errors->has('user_id') ? $errors->first('user_id') : '') }}</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('image_id', 'Ảnh:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <?php $image = Modules\Cms\Entities\Image::find($article->image_id); ?>
                    <img style="width: 200px;" src="{!! asset('/uploads/articles/'.$image['name']) !!}" />
                    <input type="hidden" name="image_current" value="{!! $image['name'] !!}">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('image_fb_id', 'Ảnh facebook:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <?php $image_fb = Modules\Cms\Entities\Image::find($article->image_fb_id); ?>
                    <img style="width: 200px;" src="{!! asset('/uploads/articles/'.$image_fb['name']) !!}"/>
                    <input type="hidden" name="image_fb_current" value="{!! $image_fb['name'] !!}">
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('status',$status[$article->status],['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="pull-right">
                <a href="{!! URL::previous() !!}" class="btn btn-primary" role="button">Đóng</a>
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
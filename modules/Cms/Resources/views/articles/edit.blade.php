@extends('cms::layouts.cms')

@section('title','Sửa Bài Viết')
@section('breadcrumbs',' Sửa Bài Viết')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Bài Viết: {{$article->title}}</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
        {!! Form::model($article, ['method' => 'PATCH', 'url'=>Route('articles.update', $article->id), 'class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}
            <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Tiêu đề:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('title',$article->title,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('title') ? $errors->first('title') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('brief')) ? 'has-error' : '' }}">
                <label for="brief" class="col-sm-2 control-label">Tóm tắt:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::textarea('brief',$article->brief,['class'=>'form-control','rows'=>3]) !!}
                    <p class="help-block">{{ ($errors->has('brief') ? $errors->first('brief') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('category_id')) ? 'has-error' : '' }}">
                <label for="category_id" class="col-sm-2 control-label">Danh mục<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::select('category_id', array('' => '--Chọn danh mục--')+$cate, null, ['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('category_id') ? $errors->first('category_id') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Nội dung:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::textarea('content',$article->content,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('content') ? $errors->first('content') : '') }}</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('source', 'Nguồn:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('source',$article->source,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group {{ ($errors->has('orderby')) ? 'has-error' : '' }}">
                {!! Form::label('orderby', 'Thứ tự:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('orderby',$article->orderby,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('orderby') ? $errors->first('orderby') : '') }}</p>
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
                {!! Form::label('image', 'Ảnh:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <?php $image = Modules\Cms\Entities\Image::find($article->image_id); ?>
                    <img style="width: 200px;" src="{!! asset('/uploads/articles/'.$image['name']) !!}" />
                    <input type="hidden" name="image_current" value="{!! $image['name'] !!}">
                </div>
            </div>
            <div class="form-group {{ ($errors->has('image')) ? 'has-error' : '' }}">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-10">
                    <input type="file" name="image">
                    <p class="help-block">{{ ($errors->has('image') ? $errors->first('image') : '') }}</p>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('image_fb', 'Ảnh facebook:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <?php $image_fb = Modules\Cms\Entities\Image::find($article->image_fb_id); ?>
                    <img style="width: 200px;" src="{!! asset('/uploads/articles/'.$image_fb['name']) !!}"/>
                        <input type="hidden" name="image_fb_current" value="{!! $image_fb['name'] !!}">
                </div>
            </div>
            <div class="form-group {{ ($errors->has('image_fb')) ? 'has-error' : '' }}">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-10">
                    <input type="file" name="image_fb">
                    <p class="help-block">{{ ($errors->has('image_fb') ? $errors->first('image_fb') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">
                {!! Form::label('Status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                @foreach (Config::get("constants.article_status") as $key=>$status)
                <label class="radio-inline">
                {!! Form::radio('status', $key) !!} {{ $status }}
                </label>
                @endforeach
                    <p class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</p>
                </div>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-success">Lưu lại</button>
                <a href="{!! Route('articles.index') !!}" class="btn btn-danger" role="button">Hủy</a>
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
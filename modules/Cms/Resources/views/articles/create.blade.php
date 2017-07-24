@extends('cms::layouts.cms')

@section('title','Tạo Mới Bài Viết')
@section('breadcrumbs','Tạo Mới Bài Viết')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Tạo mới bài viết</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
            {!! Form::open(array('method' => 'POST', 'route' => 'articles.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
            <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Tiêu Đề<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('title',null,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('title') ? $errors->first('title') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('brief')) ? 'has-error' : '' }}">
                <label for="title" class="col-sm-2 control-label">Tóm Tắt<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::textarea('brief',null,['class'=>'form-control','rows'=>3]) !!}
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
                <label for="content" class="col-sm-2 control-label">Nội Dung<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::textarea('content',null,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('content') ? $errors->first('content') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('source')) ? 'has-error' : '' }}">
                <label for="source" class="col-sm-2 control-label">Nguồn</label>
                <div class="col-sm-10">
                    {!! Form::text('source',null,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('source') ? $errors->first('source') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('orderby')) ? 'has-error' : '' }}">
                <label for="orderby" class="col-sm-2 control-label">Thứ Tự</label>
                <div class="col-sm-10">
                    {!! Form::text('orderby',null,['class'=>'form-control']) !!}
                    <p class="help-block">{{ ($errors->has('orderby') ? $errors->first('orderby') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('image')) ? 'has-error' : '' }}">
                <label for="image_id" class="col-sm-2 control-label">Ảnh<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    <input type="file" name="image">
                    <p class="help-block">{{ ($errors->has('image') ? $errors->first('image') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('image_fb')) ? 'has-error' : '' }}">
                <label for="image_id" class="col-sm-2 control-label">Ảnh Facebook<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    <input type="file" name="image_fb">
                    <p class="help-block">{{ ($errors->has('image_fb') ? $errors->first('image_fb') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">
                {!! Form::label('Status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <label class="radio-inline">
                        {!! Form::radio('status', '0',true) !!} Chưa duyệt
                    </label>
                    <label class="radio-inline">
                        {!! Form::radio('status', '1') !!} Đã duyệt
                    </label>
                    <p class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</p>
                </div>
            </div>
            <div class="row pull-right">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
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
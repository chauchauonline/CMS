@extends('cms::layouts.cms')

@section('title', 'Tên Đối Tác')
@section('breadcrumbs', 'Tên Đối Tác ')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Đối tác</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        {!! Form::open(array('method' => 'POST', 'route' => 'companies.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Tên:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('name') ? $errors->first('name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('orderby')) ? 'has-error' : '' }}">
                <label for="orderby" class="col-sm-2 control-label">Thứ tự:</label>
                <div class="col-sm-10">
                    {!! Form::text('orderby', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('orderby') ? $errors->first('orderby') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('source')) ? 'has-error' : '' }}">
                <label for="source" class="col-sm-2 control-label">Website:</label>
                <div class="col-sm-10">
                {!! Form::text('source', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('source') ? $errors->first('source') : '') }}</p>
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
                <label for="image_id" class="col-sm-2 control-label">Ảnh:<span class="field-asterisk">*</span></label>
                <div class="col-sm-10">
                    <input type="file" name="image">
                    <p class="help-block">{{ ($errors->has('image') ? $errors->first('image') : '') }}</p>
                </div>
            </div>
            <div class=" pull-right">
                <button type="submit" class="btn btn-success ">Lưu lại</button>
                <a href="{{ Route('companies.index') }}" class="btn btn-danger" role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop

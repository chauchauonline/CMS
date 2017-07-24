@extends('cms::layouts.cms')

@section('title')
{{ $mode == 'create' ? 'Tạo nhóm mới' : 'Chỉnh sửa nhóm ' }}
@stop
@section('breadcrumbs')
{{ $mode == 'create' ? 'Tạo nhóm mới' : 'Chỉnh sửa nhóm ' }}
@stop

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">{{ $mode == 'create' ? 'Tạo mới' : 'Chỉnh sửa nhóm: ' }} <small>{{ $mode === 'update' ? $role->name : null }}</small></h3>
  </div>
</div>

{!! Form::open(array('class' => 'form-horizontal container-web')) !!}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : null }}">
        <label for="name" class="col-sm-3 control-label">Tên<span class="field-asterisk">*</span></label>
        <div class="col-sm-7">
            {!! Form::text('name', $role->name, array('class' => 'form-control')) !!}
            <p class="help-block">{!! $errors->first('name') !!}</p>
        </div>
    </div>

    <div class="form-group{{ $errors->has('slug') ? ' has-error' : null }}">
        <label for="slug" class="col-sm-3 control-label">Slug<span class="field-asterisk">*</span></label>
        <div class="col-sm-7">
            {!! Form::text('slug', $role->slug, array('class' => 'form-control')) !!}
            <p class="help-block">{!! $errors->first('slug') !!}</p>
        </div>
    </div>

    <div class="col-sm-4 pull-right">
        <button type="submit" class="btn btn-success ">Thêm</button>
        <a href="{{ URL::to('roles') }}" class="btn btn-danger " role="button">Hủy</a>
    </div>
{!! Form::close() !!}

@stop


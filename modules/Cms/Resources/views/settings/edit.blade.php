@extends('cms::layouts.cms')

@section('title', 'Setting')
@section('breadcrumbs', 'Setting')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h4 class="no-margin">{{ $setting_variables[$key] }}</h4>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {!! Form::open(['method' => 'PATCH', 'route' => ['settings.update', $key], 'class' => 'form-horizontal']) !!}
            <label for="name" class="col-sm-1 control-label">Giá trị:<span class="field-asterisk">*</span></label>
                <div class="form-group {{ ($errors->has('value')) ? 'has-error' : '' }}">
                    <div class="col-sm-7">
                        {!! Form::textarea('value', $value, ['class'=>'form-control', 'rows' => '2']) !!}
                        <p class='help-block'>{{ ($errors->has('value') ? $errors->first('value') : '') }}</p>
                    </div>
                </div>
                @if($key == 'about_us')
                    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
                        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
                        crossorigin="anonymous"></script>
                    <script type="text/javascript">
                        $(function(){
                            CKEDITOR.replace( 'value', options);
                        });
                    </script>
                @endif
            <div class="col-md-5 pull-right">
                <button type="submit" class="btn btn-success ">Lưu lại</button>
                <a href="{{ Route('settings.index') }}" class="btn btn-danger" role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop

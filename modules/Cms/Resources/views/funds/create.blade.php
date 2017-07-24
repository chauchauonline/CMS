@extends('cms::layouts.cms')

@section('title', 'Tạo thu/chi mới')
@section('breadcrumbs', 'Tạo thu/chi mới')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Tạo thu/chi mới</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        {!! Form::open(array('method' => 'POST', 'route' => 'funds.store', 'class' => 'form-horizontal')) !!}
            <div class="form-group {{ ($errors->has('type')) ? 'has-error' : '' }}">
                {!! Form::label('Status', 'Loại:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-7">
                    @foreach ($fund_types as $key=>$label)
                        @if($key == 0)
                            <label class="radio-inline">
                            {!! Form::radio('type', $key, true) !!} {{ $label }}
                            </label>
                        @else
                            <label class="radio-inline">
                            {!! Form::radio('type', $key) !!} {{ $label }}
                            </label>
                        @endif
                    @endforeach
                    <p class="help-block">{{ ($errors->has('type') ? $errors->first('type') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Nội dung:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::textarea('content', null, ['class'=>'form-control', 'rows' => 4]) !!}
                    <p class='help-block'>{{ ($errors->has('content') ? $errors->first('content') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('amount')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Số tiền:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::text('amount', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('amount') ? $errors->first('amount') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('date')) ? 'has-error' : '' }}">
                {!! Form::label('Ngày', 'Ngày thu/chi:', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-7'>
                    <div class='input-group date' id='datetimepickers'>
                        {!! Form::input('text','date', null, ['class'=>'form-control', 'placeholder'=>'dd/mm/yyyy'])  !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="help-block">{{ ($errors->has('date') ? $errors->first('date') : '') }}</p>
                </div>
            </div>

             <div class="col-md-5 pull-right">
                <button type="submit" class="btn btn-success ">Lưu lại</button>
                <a href="{{ Route('funds.index') }}" class="btn btn-danger" role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
    <script type="text/javascript">
    $(function () {
        $('#datetimepickers').datetimepicker({
            format: 'DD/MM/YYYY',
        });
    });
    </script>
@stop


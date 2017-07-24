@extends('cms::layouts.cms')

@section('title', 'Cập nhật tổng quỹ hội')
@section('breadcrumbs', 'Cập nhật tổng quỹ hội')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Cập nhật tổng quỹ hội</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
          {!! Form::model($total_fund,['method' => 'PATCH','route'=>['total_fund.update' , $total_fund->id], 'class' => 'form-horizontal']) !!}
            <div class="form-group {{ ($errors->has('total')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Tổng số tiền:<span class="field-asterisk">*</span></label>
                <div class="col-sm-5">
                    {!! Form::text('total', $total_fund->total, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('total') ? $errors->first('total') : '') }}</p>
                </div>
            </div>

            <div class="form-group col-sm-7 pull-right">
                <button type="submit" class="btn btn-success ">Lưu lại</button>
                <a href="{{ Route('funds.index') }}" class="btn btn-danger" role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop


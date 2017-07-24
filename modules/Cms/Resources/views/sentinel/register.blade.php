@extends('cms::layouts.login')

@section('title', 'Đăng ký')
@section('breadcrumbs', 'Đăng ký')
@section('content')
 <div class="login-widget animation-delay1">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <i class="fa fa-lock fa-lg"></i> Đăng ký
            </div>
        </div>
        <div class="panel-body">
            {{ Form::open(array('class' => 'form-login')) }}
                <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                    <label>Họ lót <span class="text-danger">*</span></label>
                    {!! Form::text('last_name', null, ['class'=>'form-control input-sm bounceIn animation-delay2']) !!}
                    <p class='help-block'>{{ ($errors->has('last_name') ? $errors->first('last_name') : '') }}</p>
                </div>

                <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                    <label>Tên <span class="text-danger">*</span></label>
                    {!! Form::text('first_name', null, ['class'=>'form-control input-sm bounceIn animation-delay2']) !!}
                    <p class='help-block'>{{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}</p>
                </div>
                <div class="form-group {{ ($errors->has('company_name')) ? 'has-error' : '' }}">
                    <label>Tên công ty <span class="text-danger">*</span></label>
                    {!! Form::text('company_name', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('company_name') ? $errors->first('company_name') : '') }}</p>
                </div>

                <div class="form-group {{ ($errors->has('mobile')) ? 'has-error' : '' }}">
                    <label>Điện thoại <span class="text-danger">*</span></label>
                    {!! Form::text('mobile', null, ['class'=>'form-control input-sm bounceIn animation-delay2']) !!}
                    <p class='help-block'>{{ ($errors->has('mobile') ? $errors->first('mobile') : '') }}</p>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : null }}">
                    <label>Email <span class="text-danger">*</span></label>
                    {{ Form::email('email', null, array('class' => 'form-control input-sm bounceIn animation-delay2')) }}
                    <p class="help-block">{{ $errors->first('email') }}</p>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : null }}">
                    <label>Mật khẩu <span class="text-danger">*</span></label>
                    {{ Form::password('password', array('class' => 'form-control  input-sm bounceIn animation-delay2')) }}
                    <p class="help-block">{{ $errors->first('password') }}</p>
                </div>
                <div class="form-group{{ $errors->has('password_confirm') ? ' has-error' : null }}">
                    <label>Nhập lại mật khẩu <span class="text-danger">*</span></label>
                    {{ Form::password('password_confirm', array('class' => 'form-control  input-sm bounceIn animation-delay2')) }}
                    <p class="help-block">{{ $errors->first('password_confirm') }}</p>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-push-4">
                        {{ Form::submit('Đăng ký', array('class' => 'btn btn-success btn-sm bounceIn ')) }}
                        {{ Form::reset('Reset', array('class' => 'btn btn-default btn-sm bounceIn ')) }}
                        <a href="{{URL::to('/')}}" class="btn btn-primary btn-sm bounceIn"> Hủy bỏ</a>
                    </div>
                </div>
            {{ Form::close() }}
        </div><!-- /panel -->
    </div><!-- /login-widget -->
</div><!-- /login-wrapper -->
@stop

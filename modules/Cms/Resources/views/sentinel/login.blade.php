@extends('cms::layouts.login')

@section('title', 'Đăng nhập')
@section('content')
    <div class="login-widget animation-delay1">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <i class="fa fa-lock fa-lg"></i> Đăng nhập
            </div>

            <div class="pull-right">
                <span style="font-size:11px;">Bạn chưa có tài khoản?</span>
                <a class="btn btn-default btn-xs login-link" href="{{URL::to('register')}}" style="margin-top:-2px;"><i class="fa fa-plus-circle"></i> Đăng ký</a>
            </div>
        </div>
        <div class="panel-body">
            {{ Form::open(['url' => Route('login'), 'class' => 'form-login', 'autocomplete' => 'off']) }}
                <div class="form-group{{ $errors->has('login') ? ' has-error' : null }}">
                    <label>Email or Phone</label>
                    {{ Form::text('login', null, ['class' => 'form-control input-sm bounceIn animation-delay2']) }}
                    <p class="help-block">{{ $errors->first('login') }}</p>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : null }}">
                    <label>Mật khẩu</label>
                    {{ Form::password('password', ['class' => 'form-control input-sm bounceIn animation-delay4']) }}
                    @if($errors->first('password'))
                        <p class="help-block">{{ $errors->first('password') }} </p>
                    @elseif($errors->any())
                    <p class="help-block text-danger"> {{ $errors->first(0, ':message')  }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label class="label-checkbox inline">
                        {{ Form::checkbox('remember', 0 , null, ['class'=>'regular-checkbox chk-delete']) }}
                        <span class="custom-checkbox info bounceIn animation-delay4"></span>
                        Nhớ lần sau
                    </label>
                </div>
                <div class="seperator"></div>
                    <div class="form-group">
                        Quên mật khẩu?<br/>
                        Click vào <a href="{{ URL::to('reset') }}" class='text-danger'> đây </a> để đặt lại mật khẩu
                    </div>
                <hr/>
                <div>
                    <div class="col-sm-4 pull-right">
                        <a href="{{ Route('site.index')}}" class="btn btn-primary btn-sm bounceIn">Quay lại</a>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <button type="submit" class="btn btn-success btn-sm bounceIn animation-delay5"><i class="fa fa-sign-in"></i> Đăng nhập</button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div><!-- /panel -->
</div><!-- /login-widget -->


@stop

@extends('cms::layouts.cms')

@section('title', 'Thêm thành viên')
@section('breadcrumbs', 'Thêm thành viên')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Thêm thành viên</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        <div class='col-sm-7'>
        {!! Form::open(['route' => 'users.store', 'class' => 'form-horizontal', 'files' => 'true']) !!}
            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <label for="last_name" class="col-sm-3 control-label">Email:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::email('email', null, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('email') ? $errors->first('email') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('share')) ? 'has-error' : '' }}">
                <label for="share" class="col-sm-3 control-label">Chia sẻ thông tin:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                @foreach ($share_info as $key=>$val)
                    @if($key == 0)
                        <label class="radio-inline">
                            {!! Form::radio('share', $key, true) !!} {{ $val }}
                        </label>
                    @else
                        <label class="radio-inline">
                            {!! Form::radio('share', $key) !!} {{ $val }}
                        </label>
                    @endif
                @endforeach
                <p class='help-block'>{{ ($errors->has('share') ? $errors->first('share') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                <label for="last_name" class="col-sm-3 control-label">Mật khẩu:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::password('password', ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('password') ? $errors->first('password') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('repeat_password')) ? 'has-error' : '' }}">
                <label for="last_name" class="col-sm-3 control-label">Nhập lại mật khẩu:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::password('repeat_password', ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('repeat_password') ? $errors->first('repeat_password') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                <label for="last_name" class="col-sm-3 control-label">Họ lót:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                {!! Form::text('last_name', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('last_name') ? $errors->first('last_name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                <label for="first_name" class="col-sm-3 control-label">Tên:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                {!! Form::text('first_name', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('mobile')) ? 'has-error' : '' }}">
                <label for="Mobile" class="col-sm-3 control-label">Điện thoại</label>
                <div class="col-sm-7">
                {!! Form::text('mobile', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('mobile') ? $errors->first('mobile') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('company_name')) ? 'has-error' : '' }}">
                <label for="company_name" class="col-sm-3 control-label">Tên công ty:</label>
                <div class="col-sm-7">
                {!! Form::text('company_name', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('company_name') ? $errors->first('company_name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('position')) ? 'has-error' : '' }}">
                <label for="position" class="col-sm-3 control-label">Chức vụ: </label>
                <div class="col-sm-7">
                {!! Form::text('position', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('position') ? $errors->first('position') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('career')) ? 'has-error' : '' }}">
                {!! Form::label('career', 'Ngành nghề:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('career', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('career') ? $errors->first('career') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('photo')) ? 'has-error' : '' }}">
                <label for="image" class="col-sm-3 control-label">Ảnh đại diện:</label>
                <div class="col-sm-7">
                {!! Form::file('image',null) !!}
                <p class='help-block'>{{ ($errors->has('photo') ? $errors->first('photo') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('other_email')) ? 'has-error' : '' }}">
                {!! Form::label('other_email', 'Email khác:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::email('other_email', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('other_email') ? $errors->first('other_email') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('fb_url')) ? 'has-error' : '' }}">
                {!! Form::label('fb_url', 'Facebook:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('fb_url', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('fb_url') ? $errors->first('fb_url') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('company_website')) ? 'has-error' : '' }}">
                {!! Form::label('company_website', 'Website công ty:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('company_website', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('company_website') ? $errors->first('company_website') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('blog')) ? 'has-error' : '' }}">
                {!! Form::label('blog', 'Blog:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('blog', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('blog') ? $errors->first('blog') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('wanted')) ? 'has-error' : '' }}">
                {!! Form::label('wanted', 'Mong đợi gì từ tổ chức:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('wanted', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('wanted') ? $errors->first('wanted') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('birthday')) ? 'has-error' : '' }}">
                {!! Form::label('Ngày sinh', 'Ngày sinh:', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-7'>
                    <div class='input-group date' id='datetimepickersbirthday'>
                        {!! Form::input('text','birthday', null, ['class'=>'form-control', 'placeholder'=>'dd/mm/yyyy'])  !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="help-block">{{ ($errors->has('birthday') ? $errors->first('birthday') : '') }}</p>
                </div>
            </div>

             <div class="form-group {{ ($errors->has('gender')) ? 'has-error' : '' }}">
                {!! Form::label('Giới tính', 'Giới tính:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                @foreach (Config::get("constants.GENDER") as $key=>$gender)
                    @if($key == 0)
                        <label class="radio-inline">
                            {!! Form::radio('gender', $key, true) !!} {{ $gender }}
                        </label>
                    @else
                        <label class="radio-inline">
                            {!! Form::radio('gender', $key) !!} {{ $gender }}
                        </label>
                    @endif
                @endforeach
                <p class='help-block'>{{ ($errors->has('gender') ? $errors->first('gender') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('address')) ? 'has-error' : '' }}">
                {!! Form::label('address', 'Địa chỉ:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('address', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('address') ? $errors->first('address') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('street')) ? 'has-error' : '' }}">
                {!! Form::label('street', 'Đường phố:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('street', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('street') ? $errors->first('street') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('district')) ? 'has-error' : '' }}">
                {!! Form::label('district', 'Quận/Huyện:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('district', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('district') ? $errors->first('district') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('city')) ? 'has-error' : '' }}">
                {!! Form::label('city', 'Tỉnh/Thành phố:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('city', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('city') ? $errors->first('city') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('state')) ? 'has-error' : '' }}">
                {!! Form::label('state', 'Bang:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('state', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('state') ? $errors->first('state') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('country')) ? 'has-error' : '' }}">
                {!! Form::label('country', 'Quốc gia:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('country', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('country') ? $errors->first('country') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('bio')) ? 'has-error' : '' }}">
                {!! Form::label('bio', 'Giới thiệu về bản thân:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::textarea('bio', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('bio') ? $errors->first('bio') : '') }}</p>
                </div>
            </div>

            <div class="col-sm-5 pull-right">
                <button type="submit" class="btn btn-success btn-sm bounceIn ">Lưu lại</button>
                <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm bounceIn " role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
        </div>
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
    <script type="text/javascript">
    $(function () {
        $('#datetimepickersbirthday').datetimepicker({
            format: 'DD/MM/YYYY',
        });
    });
    </script>
@stop

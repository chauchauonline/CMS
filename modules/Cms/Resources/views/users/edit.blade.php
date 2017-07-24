@extends('cms::layouts.cms')

@section('title', 'Cập nhật thông tin thành viên')
@section('breadcrumbs', 'Cập nhật thông tin thành viên')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Cập nhật thông tin</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        <div class='col-sm-7'>
        {!! Form::model($user,['method' => 'PATCH','route'=>['users.update' , $user->id], 'class' => 'form-horizontal container-web']) !!}
            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <label for="share" class="col-sm-3 control-label">Email:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::email('email', $user->email, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('email') ? $errors->first('email') : '') }}</p>
                </div>
            </div>
            @if($user->id == $current_user_id)
            <div class="form-group {{ ($errors->has('share')) ? 'has-error' : '' }}">
                <label for="share" class="col-sm-3 control-label">Chia sẻ thông tin:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                @foreach ($share_info as $key=>$val)
                    @if($key == $user->share)
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
            @endif
            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                {!! Form::label('Mật khẩu', 'Mật khẩu:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::password('password', ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('password') ? $errors->first('password') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('repeat_password')) ? 'has-error' : '' }}">
                {!! Form::label('Nhập lại mật khẩu', 'Nhập lại mật khẩu:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::password('repeat_password', ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('repeat_password') ? $errors->first('repeat_password') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                <label for="last_name" class="col-sm-3 control-label">Họ lót:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                {!! Form::text('last_name', $user->last_name, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('last_name') ? $errors->first('last_name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                <label for="first_name" class="col-sm-3 control-label">Tên:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                {!! Form::text('first_name', $user->first_name, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}</p>
                </div>
            </div>
            <div class="form-group {{ ($errors->has('mobile')) ? 'has-error' : '' }}">
                <label for="Mobile" class="col-sm-3 control-label">Điện thoại</label>
                <div class="col-sm-7">
                {!! Form::text('mobile', $user->mobile, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('mobile') ? $errors->first('mobile') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('company_name')) ? 'has-error' : '' }}">
                <label for="company_name" class="col-sm-3 control-label">Tên công ty:</label>
                <div class="col-sm-7">
                {!! Form::text('company_name', $user->company_name, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('company_name') ? $errors->first('company_name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('position')) ? 'has-error' : '' }}">
                <label for="position" class="col-sm-3 control-label">Chức vụ:</label>
                <div class="col-sm-7">
                {!! Form::text('position', $user->position, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('position') ? $errors->first('position') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('career')) ? 'has-error' : '' }}">
                {!! Form::label('career', 'Ngành nghề:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('career', $user->career, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('career') ? $errors->first('career') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('other_email')) ? 'has-error' : '' }}">
                {!! Form::label('other_email', 'Email khác:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::email('other_email', $user->other_email, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('other_email') ? $errors->first('other_email') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('fb_url')) ? 'has-error' : '' }}">
                {!! Form::label('fb_url', 'Facebook:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('fb_url', $user->fb_url, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('fb_url') ? $errors->first('fb_url') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('company_website')) ? 'has-error' : '' }}">
                {!! Form::label('company_website', 'Website công ty:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('company_website', $user->company_website, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('company_website') ? $errors->first('company_website') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('blog')) ? 'has-error' : '' }}">
                {!! Form::label('blog', 'Blog:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('blog', $user->blog, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('blog') ? $errors->first('blog') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('wanted')) ? 'has-error' : '' }}">
                {!! Form::label('wanted', 'Mong đợi gì từ tổ chức:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('wanted', $user->wanted, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('wanted') ? $errors->first('wanted') : '') }}</p>
                </div>
            </div>

             <div class="form-group {{ ($errors->has('birthday')) ? 'has-error' : '' }}">
                {!! Form::label('Ngày sinh', 'Ngày sinh:', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-7'>
                    <div class='input-group date' id='datetimepickersbirthday'>
                        {!! Form::input('text','birthday', ($user->birthday == '0000-00-00 00:00:00' || $user->birthday == null ) ? null : \Carbon\Carbon::parse($user->birthday)->format('d/m/Y'),
                                 ['class'=>'form-control', 'placeholder'=>'dd/mm/yyyy'])  !!}
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
                    @if($key == $user->gender)
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
                {!! Form::text('address', $user->address, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('address') ? $errors->first('address') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('street')) ? 'has-error' : '' }}">
                {!! Form::label('street', 'Đường phố:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('street', $user->street, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('street') ? $errors->first('street') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('district')) ? 'has-error' : '' }}">
                {!! Form::label('district', 'Quận/Huyện:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('district', $user->district, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('district') ? $errors->first('district') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('city')) ? 'has-error' : '' }}">
                {!! Form::label('city', 'Tỉnh/Thành phố:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('city', $user->city, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('city') ? $errors->first('city') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('state')) ? 'has-error' : '' }}">
                {!! Form::label('state', 'Bang:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('state', $user->state, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('state') ? $errors->first('state') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('country')) ? 'has-error' : '' }}">
                {!! Form::label('country', 'Quốc gia:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::text('country', $user->country, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('country') ? $errors->first('country') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('bio')) ? 'has-error' : '' }}">
                {!! Form::label('bio', 'Giới thiệu về bản thân:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                {!! Form::textarea('bio', $user->bio, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('bio') ? $errors->first('bio') : '') }}</p>
                </div>
            </div>

            <div class="col-sm-5 pull-right">
                <button type="submit" class="btn btn-success btn-sm bounceIn">Lưu lại</button>
                <a href="{{ Route('users.index') }}" class="btn btn-danger btn-sm bounceIn" role="button">Hủy</a>

            </div>
        {!! Form::close() !!}
        </div>
        <div class="col-sm-5">
            <?php $image = Modules\Cms\Entities\Image::find($user->photo); ?>
            @if(!$image)
                <img src="{{Config::get('constants.NONE_IMAGE_SOURCE')}}" style="width:225px;height:225;">
            @else
                <img src="{{  Image::url(asset($image->thumbs),225,225,array('crop')) }}" alt="{{$user->last_name." ".$user->first_name }}">
            @endif
                <form action="{{Route('users.upload')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <br>
                    <div class="col-sm-4">
                        <input type="file" name="photo">
                        <p class='text-danger'>{{ ($errors->has('photo') ? $errors->first('photo') : '') }}</p>
                        <button type="submit" class="btn btn-default btn-sm bounceIn"><i class="fa fa-upload"></i> Lưu lại</button>
                    </div>
                </form>
        </div>
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
    <script type="text/javascript">
    $(function () {
    	$('#datetimepickersbirthday').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@stop
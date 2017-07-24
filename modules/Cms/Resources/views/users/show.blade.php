@extends('cms::layouts.cms')

@section('title', 'Thông tin hội viên')
@section('breadcrumbs', 'Thông tin hội viên')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Thông tin hội viên</h3>
  </div>
  <div class="pull-right">
        <a class="btn btn-success" href="{{ Route('users.edit', $user->id) }}"> Chỉnh sửa thông tin</a>
    </div><!-- row -->
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tbody>
                <tr>
                    <th class="text-center">Ảnh</th>
                    <?php $image = Modules\Cms\Entities\Image::find($user->photo); ?>
                    @if(!$image)
                        <th><img src="{{ Config::get('constants.NONE_IMAGE_SOURCE')}} " alt="{{$user->last_name." ".$user->first_name }}" style="width:225px;"></th>
                    @else
                        <th><img src="{{  Image::url(asset($image->thumbs),225,225,array('crop')) }}" alt="{{$user->last_name." ".$user->first_name }}"></th>
                    @endif
                </tr>
                <tr>
                    <th class="text-center">Họ tên</th>
                    <th> {{ $user->last_name.' '.$user->first_name }}</th>
                </tr>
                <tr>
                    <th class="text-center">Chia sẻ thông tin</th>
                    <th> {{ $share_info[$user->share] }}</th>
                </tr>
                <tr>
                    <th class="text-center">Số điện thoại</th>
                    <th> {{ $user->mobile }}</th>
                </tr>
                <tr>
                    <th class="text-center">Tên công ty</th>
                    <th> {{ $user->company_name}}</th>
                </tr>
                <tr>
                    <th class="text-center">Ngành nghề</th>
                    <th> {{ $user->career }} </th>
                </tr>
                <tr>
                    <th class="text-center">Chức vụ</th>
                    <th> {{ $user->position }} </th>
                </tr>
                <tr>
                    <th class="text-center">Email</th>
                    <th>{{ $user->email }}</th>
                </tr>
                <tr>
                    <th class="text-center">Email khác</th>
                    <th>{{ $user->other_email }}</th>
                </tr>
                <tr>
                    <th class="text-center">Facebook</th>
                    <th><a href="{{$user->fb_url}}" class="text-info">{{ $user->fb_url }}</a></th>
                </tr>
                <tr>
                    <th class="text-center">Website công ty</th>
                    <th>{{ $user->company_website }}</th>
                </tr>
                <tr>
                    <th class="text-center">Blog</th>
                    <th>{{ $user->blog }}</th>
                </tr>
                <tr>
                    <th class="text-center">Ngày sinh</th>
                    <th>@if($user->birthday != '0000-00-00 00:00:00' && $user->birthday != null) {{ \Carbon\Carbon::parse($user->birthday)->format('d-m-Y') }} @endif</th>
                </tr>
                <tr>
                    <th class="text-center">Giới tính</th>
                    <th>{{ $gender[$user->gender] }}</th>
                </tr>
                <tr>
                    <th class="text-center">Địa chỉ</th>
                    <th>{{ $user->address }}</th>
                </tr>
                <tr>
                    <th class="text-center">Tiểu sử</th>
                    <th>{{ $user->bio }}</th>
                </tr>
                <tr>
                    <th class="text-center">Đường phố</th>
                    <th>{{ $user->street }}</th>
                </tr>
                <tr>
                    <th class="text-center">Quận huyện</th>
                    <th>{{ $user->district }}</th>
                </tr>
                <tr>
                    <th class="text-center">Tỉnh/Thành phố</th>
                    <th>{{ $user->city }}</th>
                </tr>
                <tr>
                    <th class="text-center">Bang</th>
                    <th>{{ $user->state }}</th>
                </tr>
                <tr>
                    <th class="text-center">Quốc gia</th>
                    <th>{{ $user->country }}</th>
                </tr>
                <tr>
                    <th class="text-center">Ngày tạo</th>
                    <th>{{ $user->created_at }}</th>
                </tr>
                <tr>
                    <th class="text-center">Lần cập nhật cuối</th>
                    <th>{{ $user->updated_at }}</th>
                </tr>
            </tbody>
        </table>
    </div><!-- /table-responsive -->
    <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm bounceIn pull-right" role="button">Đóng</a>
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop

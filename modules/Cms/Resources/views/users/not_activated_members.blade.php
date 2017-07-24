@extends('cms::layouts.cms')

@section('title', 'Danh sách hội viên đăng ký mới')
@section('breadcrumbs', 'Danh sách hội viên đăng ký mới')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Danh sách hội viên đăng ký mới</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            {!! Form::open(array('method' => 'GET', 'route' => 'users.not_activated_members', 'id'=>'form-search-users', 'role'=>'search')) !!}
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group">
                    {!! Form::text('keyword', app('request')->get('keyword'), ['class'=>'form-control', 'placeholder'=>'Nhập từ khóa']) !!}
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="form-group">
                    <button class="btn btn-info" type="submit">Tìm</button>
                  </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="page-right">
            {!! $members->links() !!}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center col-sm-1">Họ tên</th>
            <th class="text-center col-sm-1">Số điện thoại</th>
            <th class="text-center col-sm-1">Email</th>
            <th class="text-center col-sm-2">Tên công ty</th>
            <th class="text-center col-sm-2">Ngày đăng ký</th>
            <th class="text-center col-sm-1">-</th>
        </thead>
        <tbody>
            @forelse ($members as $key => $member)
            <?php $image = Modules\Cms\Entities\Image::find($member['photo']);?>
            <tr>
                <td>{{ $member['last_name']. ' ' .$member['first_name'] }}</td>
                <td class="text-center">{{ $member['mobile'] }}</td>
                <td class="text-center">{{ $member['email'] }}</td>
                <td class="text-left">{{ $member['company_name'] }} </td>
                <td class="text-left">{{ $member['created_at'] }} </td>
                <td class="text-center valignMiddle">
                    <a class="btn btn-success" href="{{ Route('activate', $member['id']) }}"><i class="fa fa-check-circle"></i> Kích hoạt tài khoản</a>
               </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class='text-center'>
                    <p>Không có dữ liệu</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
      {!! $members->links() !!}
    </div><!-- page-right -->
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop


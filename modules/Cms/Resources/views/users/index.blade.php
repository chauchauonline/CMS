@extends('cms::layouts.cms')

@section('title', 'Danh sách hội viên')
@section('breadcrumbs', 'Danh sách hội viên')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Danh sách hội viên</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            {!! Form::open(array('method' => 'GET', 'route' => 'users.index', 'id'=>'form-search-users', 'role'=>'search')) !!}
                <div class="col-sm-4 col-md-3 col-lg-3">
                    <div class="form-group">
                    {!! Form::text('keyword', app('request')->get('keyword'), ['class'=>'form-control', 'placeholder'=>'Nhập từ khóa']) !!}
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-3">
                  <div class="form-group">
                    <button class="btn btn-info" type="submit">Tìm</button>
                  </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="page-right">
            {!! $users->appends(\Input::except('page'))->render() !!}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center col-sm-2"></th>
            <th class="text-center col-sm-2">Họ tên</th>
            <th class="text-center col-sm-1">Chia sẻ thông tin</th>
            <th class="text-center col-sm-1">Số điện thoại</th>
            <th class="text-center col-sm-2">Nghề nghiệp</th>
            <th class="text-center col-sm-1">Nhóm</th>
            <th class="text-center col-sm-1">Quyền hệ thống</th>
            <th class="text-center col-sm-2">-</th>
        </thead>
        <tbody>
            @forelse ($users as $member)
            <?php $image = Modules\Cms\Entities\Image::find($member->photo);?>
            <tr>
                <td class="text-center">
                    @if($image)
                        <img src="{{$image->thumbs}}" alt="Ảnh" style="width:155px;">
                    @else
                        <img src="{{Config::get('constants.NONE_IMAGE_SOURCE')}}" alt="Ảnh" style="width:155px;">
                    @endif
                </td>
                <td>{{ $member->last_name. ' ' .$member->first_name }}</td>
                <td class="text-center">{{ $share_info[$member->share] }}</td>
                <td class="text-center">{{ $member->mobile }}</td>
                <td class="text-left">
                 Công ty:   {{ $member->company_name }}<br>
                 Vị trí:   {{ $member->position }}<br>
                 Ngành nghề:   {{ $member->career }}
                </td>
                <?php $sentinel = Sentinel::findById($member->id);?>
                <td class="text-center">
                    @foreach($sentinel->roles as $role)
                        {{ $role['name'] }}
                    @endforeach
                </td>
                <td class="text-center">

                </td>
                <td class="text-center valignMiddle">
                    <div class="btn-group">
                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::route('users.show', $member->id) }}"><i class="fa fa-eye"></i> Chi tiết</a></li>
                            @if($user = Sentinel::check())
                                @if($user->inRole('admin'))
                                    <li>
                                        <a href="{{ URL::route('users.edit', $member->id) }}"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                                    </li>
                                    @if($user->id != $member->id)
                                        <li><a data-target="#ModalChangePermission" data-toggle="modal" data_id="{{ $member->id }}" href="javascript:void(0)" class="changePermission">
                                                    <i class="fa fa-trophy"></i> Cấp quyền</a></li>
                                        <li><a class="delete" data_id="{{ $member->id }}"><i class="fa fa-trash-o"></i> Xóa</a></li>
                                        <li><a class="btn btn-danger" href="{{ Route('lock', $member->id) }}"><i class="fa fa-lock"></i> Khóa tài khoản</a></li>
                                    @endif
                                @endif
                            @endif
                        </ul>
                    </div><!-- /btn-group -->
               </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class='text-center'>
                    <p>Không tìm thấy hội viên</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
      {!! $users->appends(\Input::except('page'))->render() !!}
    </div><!-- page-right -->

    {!! Form::open(['method' => 'DELETE', 'route'=>['users.delete'], 'id'=>'frm_delete']) !!}
       {!! Form::hidden('id', 0, array('id' => 'user_id')) !!}
    {!! Form::close() !!}
</div><!-- /panel-body -->
</div><!-- /panel -->

<!-- Begin ModalChangePermission -->
  <div class="modal fade" id="ModalChangePermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="modal-content-change-permission">
        <div class="modal-header">
          <button type="button" class="close close-ModalChangePermission" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Phân quyền</h4>
        </div><!-- modal-header -->
        <div class="modal-body">
            {!! Form::open(['method'=>'post', 'route' => ['users.save_permission'], 'class' => 'form-horizontal form-border no-margin']) !!}
                {!! Form::hidden('member_id', null, ['id' => 'member_id_permission']) !!}
                  <div class="form-group{{ $errors->has('role') ? ' has-error' : null }}">
                    <label for="roles" class="col-sm-3 control-label">Nhóm</label>
                    <div class="col-sm-7">
                        {!! Form::select('role', $roles, $role_default,  ['class' => 'form-control'] ) !!}
                        <p class="help-block">{!! $errors->first('role') !!}</p>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('permissions') ? ' has-error' : null }}">
                    <label for="permissions" class="col-sm-3 control-label">Quyền</label>
                    <div class="col-sm-8">
                        @foreach ($permissions as $permission=>$label)
                            <label class="checkbox">
                                @if($permission == $permission_default)
                                    {!! Form::checkbox('permissions[]', $permission, true) !!} {{ $label }}
                                @else
                                    {!! Form::checkbox('permissions[]', $permission) !!} {{ $label }}
                                @endif
                            </label>
                        @endforeach
                        <p class="help-block">{!! $errors->first('permissions') !!}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Lưu lại</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                </div><!-- modal-footer -->
            {!! Form::close() !!}
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- Modal -->
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $(".delete").click(function(e){
            if(!confirm('Bạn có chắc muốn xóa hội viên này?')){
                e.preventDefault();
                return false;
            }
            $('#user_id').val($(this).attr('data_id'));
            $('#frm_delete').submit();
            return true;
        });
        $(".changePermission").click(function(e){
            $('#member_id_permission').val($(this).attr('data_id'));
        });
    });
</script>
@stop


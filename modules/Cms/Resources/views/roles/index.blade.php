@extends('cms::layouts.cms')

@section('title', 'Nhóm quyền')
@section('breadcrumbs', 'Nhóm quyền')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Danh sách nhóm quyền</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
          <div class="col-sm-12">
            <a href="{{ URL::route('roles.create') }}" class="btn btn-success">Tạo nhóm mới</a>
          </div><!-- col -->
        </div><!-- row -->
        <hr />
    </div>
    <div class="panel-body">
        <div class="page-right">
            {{ $roles->links() }}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center">Tên</th>
            <th class="text-center">Slug</th>
            <th class="text-center">Quyền</th>
            <th class="text-center">-</th>
        </thead>
        <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td class="text-center">{{ $role->name }}</td>
                    <td class="text-center">{{ $role->slug }}</td>
                    <td class="text-center">
                        @foreach ($role->permissions as $key=>$value)
                            {{ $key }}
                        @endforeach
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::route('roles.edit', $role->id) }}"><i class="fa fa-edit"></i> Sửa</a></li>
                                <li><a class="delete" data_id="{{$role->id}}"><i class="fa fa-trash-o"></i> Xóa</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="4">
                <p>Không có nhóm tìm thấy</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
      {{ $roles->links() }}
    </div><!-- page-right -->
</div><!-- /panel-body -->
{!! Form::open(['method' => 'DELETE', 'route'=>['roles.delete'], 'id'=>'frm_delete']) !!}
    {!! Form::hidden('id', 0, array('id' => 'role_id')) !!}
{!! Form::close() !!}
</div><!-- /panel -->

@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete").click(function(e){
                if(!confirm('Bạn có chắc muốn xóa?')){
                    e.preventDefault();
                    return false;
                }
                $('#role_id').val($(this).attr('data_id'));
                $('#frm_delete').submit();
                return true;
                return true;
            });
        });
</script>
@stop
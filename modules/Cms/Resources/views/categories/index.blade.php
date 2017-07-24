@extends('cms::layouts.cms')

@section('title', 'Danh mục')
@section('breadcrumbs', 'Danh mục')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Danh mục</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
          <div class="col-sm-12">
            <a href="{{ URL::route('categories.create') }}" class="btn btn-success">Tạo danh mục mới</a>
          </div><!-- col -->
        </div><!-- row -->
        <hr />
    </div>
    <div class="panel-body">
        <div class="page-right">
            {{ $categories->links() }}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center col-sm-2">Tên</th>
            <th class="text-center col-sm-2">Slug</th>
            <th class="text-center col-sm-2">Trạng thái</th>
            <th class="text-center col-sm-1">Màu sắc</th>
            <th class="text-center col-sm-2">Mô tả</th>
            <th class="text-center col-sm-3">-</th>
        </thead>
        <tbody>
            @forelse ($categories as $cate)
                <tr>
                    <td class="text-center">{{ $cate->name }}</td>
                    <td class="text-center">{{ $cate->slug }}</td>
                    <td class="text-center">{{ $category_status[$cate->status] }}</td>
                    <td class="text-center"><h4 style="color: #ffffff"><span class="ebtn" style="background-color: {{$cate->color}}"> {{ $cate->color}} </span></h4></td>
                    <td><div style="overflow:auto; max-height:100px;">{{ $cate->description }}</div></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::route('categories.show', $cate->id) }}"><i class="fa fa-eye"></i> Xem</a></li>
                                <li><a href="{{ URL::route('categories.edit', $cate->id) }}"><i class="fa fa-edit"></i> Sửa</a></li>
                                <li><a class="delete" data_id="{{$cate->id}}"><i class="fa fa-trash-o"></i> Xóa</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="6">
                <p>Không có danh mục nào</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
      {{ $categories->links() }}
    </div><!-- page-right -->
</div><!-- /panel-body -->
{!! Form::open(['method' => 'DELETE', 'route'=>['categories.delete'], 'id'=>'frm_delete']) !!}
    {!! Form::hidden('id', 0, array('id' => 'category_id')) !!}
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
                $('#category_id').val($(this).attr('data_id'));
                $('#frm_delete').submit();
                return true;
            });
        });
</script>
@stop
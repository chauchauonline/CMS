@extends('cms::layouts.cms')

@section('title', 'Danh sách trang')
@section('breadcrumbs', 'Danh sách trang')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Danh sách trang</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="page-right">
            {!! $pages->links() !!}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center">Tên trang</th>
            <th class="text-center">Hình ảnh</th>
            <th class="text-center">Thứ tự</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">-</th>
        </thead>
        <tbody>
            @forelse ($pages as $page)
            <tr>
                <td class="text-center col-sm-2">{{ $page->name }}</td>
                <td class="text-center col-sm-2">
                 <?php $image = Modules\Cms\Entities\Image::find($page->image_id);?>
                    @if($image)
                        <img src="{{$image->thumbs}}" alt="{{ $page->name }}" style="width:200px;">
                    @endif
                </td>
                <td class="text-center col-sm-2">{{ $page->order }}</td>
                <td class="text-center col-sm-2">{{ $page_status[$page->status] }}</td>
                <td class="text-center col-sm-1">
                    <div class="btn-group">
                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::route('pages.show', $page->id) }}"><i class="fa fa-eye"></i> Xem</a></li>
                            <li><a href="{{ URL::route('pages.edit', $page->id) }}"><i class="fa fa-edit"></i> sửa</a></li>
                            <li><a href="{{ URL::route('pages.change_image', $page->id) }}"><i class="fa fa-picture-o"></i> Đổi ảnh</a></li>
                            <li><a class="delete" data_id="{{ $page->id }}"><i class="fa fa-trash-o"></i> Xóa</a></li>
                        </ul>
                    </div><!-- /btn-group -->
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                <p>Không tìm thấy trang</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->

    {!! Form::open(['method' => 'DELETE', 'route'=>['pages.delete'], 'id'=>'frm_delete']) !!}
       {!! Form::hidden('id', 0, array('id' => 'page_id')) !!}
    {!! Form::close() !!}

    <div class="page-right">
      {!! $pages->links() !!}
    </div><!-- page-right -->
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $(".delete").click(function(e){
            if(!confirm('Bạn có chắc muốn xóa trang này?')){
                e.preventDefault();
                return false;
            }
            $('#page_id').val($(this).attr('data_id'));
            $('#frm_delete').submit();
            return true;
        });
    });
</script>
@stop

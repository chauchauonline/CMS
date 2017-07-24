@extends('cms::layouts.cms')

@section('title', 'Xem chi tiết trang')
@section('breadcrumbs', 'Xem chi tiết trang')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Xem chi tiết trang</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <tbody>
            <tr>
                <th>Tên trang</th>
                <td>{{ $page->name }}</td>
            </tr>
            <tr>
                <th>Hình ảnh</th>
                <td>
                     <?php $image = Modules\Cms\Entities\Image::find($page->image_id);?>
                        @if($image)
                            <img src="{{$image->thumbs}}" alt="Ảnh" style="width:200px;">
                        @endif
                </td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ $page->slug }}</td>
            </tr>
            <tr>
                <th>Thứ tự</th>
                <td>{{ $page->order }}</td>
            </tr>
            <tr>
                <th>Banner</th>
                <td>{{ $page->banner }}</td>
            </tr>
            <tr>
                <th>View</th>
                <td>{{ $page->view }}</td>
            </tr>
            <tr>
                <th>Template</th>
                <td>{{ $enum_compiler[$page->compiler] }}</td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>{{ $page_status[$page->status] }}</td>
            </tr>
            <tr>
                <th>Thư mục upload</th>
                <td>{{ $page->upload_folder }}</td>
            </tr>
            <tr>
                <th>Heading</th>
                <td>{{ $page->heading }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $page->title }}</td>
            </tr>
            <tr>
                <th>Nội dung</th>
                <td>{!! Form::textarea('content', $page->content, ['class'=>'form-control']) !!}</td>
            </tr>
            <tr>
                <th>Từ khóa</th>
                <td>{{ $page->keyword }}</td>
           </tr>
           <tr>
                <th>Mô tả</th>
                <td>{{ $page->description }}</td>
            </tr>
            <tr>
                <th>Tóm tắt</th>
                <td>{{ $page->abstract }}</td>
            </tr>
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <a href="{{ Route('pages.index') }}" class ="btn btn-danger btn-sm bounceIn pull-right" role="button"">Đóng</a>
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
<script type="text/javascript">
    $(function(){
        CKEDITOR.replace( 'content', options);
    });
</script>
@stop

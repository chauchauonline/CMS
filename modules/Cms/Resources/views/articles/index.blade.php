@extends('cms::layouts.cms')

@section('title','Danh Sách Bài Viết')
@section('breadcrumbs','Danh Sách Bài Viết')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Danh Sách Bài Viết</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-12"><a class="btn btn-success" href="{{ URL::route('articles.create') }}">Bài Viết
                        Mới</a></div><!-- col -->
            </div><!-- row -->
            <div class="row" style="margin-top: 20px">
                {!! Form::open(array('method' => 'GET', 'route' => 'articles.index', 'id'=>'form-search-users', 'role'=>'search')) !!}
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" value="{{Request::get('keyword', '')}}" placeholder="Nhập từ khóa">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group">
                        <button class="btn btn-info" type="submit">Tìm</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="row">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="bus-table">
                            <thead>
                            <tr>
                                <th class="text-center col-sm-2">Ảnh</th>
                                <th class="text-center col-sm-4">Tiêu đề</th>
                                <th class="text-center col-sm-1">Thứ Tự</th>
                                <th class="text-center col-sm-1">Trạng thái</th>
                                <th class="text-center col-sm-1">Ngày viết bài</th>
                                <th class="text-center col-sm-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($article as $data)
                                <tr>
                                    <td class="text-center"> <?php $image = Modules\Cms\Entities\Image::find($data->image_id); ?>
                                        @if($image)
                                            <img style="width: 155px;" src="{!! asset('uploads/articles/'.$image['name']) !!}" alt="Image not found"/>
                                        @else
                                            <img style="width: 155px;" src="{!! asset('uploads/articles/'.$image['name']) !!}" alt="Image not found"/>
                                        @endif
                                    </td>
                                    <td>{!! $data->title !!} </td>
                                    <td class="text-center">{!! $data->orderby !!}</td>
                                    <td class="text-center">{!! $status[$data->status] !!}</td>
                                    <td class="text-center">{!! \Carbon\Carbon::createFromTimestamp(strtotime($data["created_at"])) !!}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{!! URl::route('articles.show',$data->id) !!}"><i class="fa fa-eye"></i> Xem</a></li>
                                                <li><a href="{!! URl::route('articles.edit',$data->id) !!}"><i class="fa fa-edit"></i> Sửa</a></li>
                                                <li><a class="delete" data_id="{{$data->id}}"><i class="fa fa-trash-o"></i> Xóa</a></li>
                                            </ul>
                                        </div><!-- /btn-group -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <p>Không có bài viết được tìm thấy</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->
                </div>
            </div><!-- /panel-body -->
            <div class="page-right">
                {!! ($article->appends(\Input::except('page'))->render()) !!}
            </div><!-- page-right -->
        </div><!-- /panel -->
    </div>
    {!! Form::open(['method' => 'DELETE', 'route'=>['articles.delete'], 'id'=>'frm_delete']) !!}
        {!! Form::hidden('id', 0, array('id' => 'article_id')) !!}
    {!! Form::close() !!}
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".delete").click(function(e){
                if(!confirm('Bạn có chắc muốn xóa?')){
                    e.preventDefault();
                    return false;
                }
                $('#article_id').val($(this).attr('data_id'));
                $('#frm_delete').submit();
                return true;
            });
        });
    </script>
@stop

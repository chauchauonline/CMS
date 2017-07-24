@extends('cms::layouts.cms')

@section('title','Danh Sách Đối Tác')
@section('breadcrumbs','Danh Sách Đối Tác')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Danh Sách Đối Tác</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-12"><a class="btn btn-success" href="{{ URL::route('companies.create') }}">Đối tác mới</a></div><!-- col -->
            </div><!-- row -->
            <div class="row" style="margin-top: 20px">
                {!! Form::open(array('method' => 'GET', 'route' => 'companies.index', 'id'=>'form-search-users', 'role'=>'search')) !!}
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
                                <th class="text-center col-sm-2">Công ty</th>
                                <th class="text-center col-sm-2">Website</th>
                                <th class="text-center col-sm-3">Mô tả</th>
                                <th class="text-center col-sm-1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($company as $data)
                                <tr>
                                    <td class="text-center"> <?php $image = Modules\Cms\Entities\Image::find($data->image); ?>
                                        @if($image)
                                            <img style="width: 155px;" src="{!! asset('uploads/partners/'.$image['name']) !!}" alt="{{ $data->name}}"/>
                                        @else
                                            <img style="width: 155px;" src="{!! asset('uploads/partners/'.$image['name']) !!}" alt="{{$data->name}}"/>
                                        @endif
                                    </td>
                                    <td class="text-center">{!! $data->name !!}</td>
                                    <td class="text-center">{!! $data->source !!}</td>
                                    <td class="text-center">{!! $data->description !!}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{!! URl::route('companies.show',$data->id) !!}" ><i class="fa fa-eye"></i> Xem</a></li>
                                                <li><a href="{!! URl::route('companies.edit',$data->id) !!}"><i class="fa fa-edit"></i> Sửa</a></li>
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
                {!! ($company->appends(\Input::except('page'))->render()) !!}
            </div><!-- page-right -->
        </div><!-- /panel -->
    </div>
{!! Form::open(['method' => 'DELETE', 'route'=>['companies.delete'], 'id'=>'frm_delete']) !!}
{!! Form::hidden('id', 0, array('id' => 'company_id')) !!}
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
                 $('#company_id').val($(this).attr('data_id'));
                 $('#frm_delete').submit();
                 return true;
             });
         });
    </script>
@stop

@extends('cms::layouts.cms')

@section('title','Danh Sách Thu/Chi Quỹ Hội')
@section('breadcrumbs','Danh Sách Thu/Chi Quỹ Hội')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Danh Sách Thu/Chi Quỹ Hội</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
            {!! Form::open(array('method' => 'GET', 'route' => 'funds.index', 'id'=>'form-filter')) !!}
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Loại thu/chi</label>
                    {!! Form::select('type', array('' => '---Chọn---')+$fund_types, app('request')->input('type'), ['class'=>'col-sm-4  form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group">
                    <label for="content" class="col-sm-4 control-label">Nội dung thu/chi</label>
                    {!! Form::textarea('content', app('request')->input('content'), ['class'=>'col-sm-4 form-control', 'rows' => 1]) !!}
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-1">
                  <div class="form-group">
                    <br>
                    <button class="btn btn-info" type="submit">Tìm</button>
                  </div>
                </div>
            {!! Form::close() !!}
            <div class="col-sm-6 col-md-4 col-lg-5">
                <div class="form-group">
                    <br>
                    <a href="{{ Route('fund_members.history', ['member_id' => $current_user->id])}}" class="btn btn-info pull-right">Xem lịch sử đóng quỹ</a>
                </div>
            </div>
            </div><!-- row -->
        </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="bus-table">
                        <thead>
                        <tr>
                            <th colspan="5">Tổng tiền quỹ hiện tại: {{  number_format($remain_fund) }}  VNĐ
                                @if($current_user->inRole('admin'))
                                    <span><a href="{{ Route('total_fund.edit') }}" class="btn btn-default"><i class="fa fa-edit"></i>Sửa</a></span>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center col-sm-2">Loại Thu/Chi</th>
                            <th class="text-center col-sm-2">Ngày</th>
                            <th class="text-center col-sm-2">Nội dung</th>
                            <th class="text-center col-sm-2">Số tiền</th>
                            <th class="text-center col-sm-4"></th>
                        </tr>
                         </thead>
                        @forelse ($funds as $data)
                         <tbody>
                            <tr>
                                <td class="text-center">{!! $fund_types[$data->type] !!}</td>
                                <td class="text-center">
                                    @if($data->date != "0000-00-00 00:00:00") {!! \Carbon\Carbon::parse($data->date)->format('d-m-Y') !!} @endif</td>
                                <td class="text-center">{!! $data->content !!}</td>
                                <td class="text-center">{!! $data->amount !!}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Hành động <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{!! URL::route('funds.show',$data->id) !!}"><i class="fa fa-eye"></i> Xem</a></li>
                                            @if($current_user->inRole('admin'))
                                                <li><a href="{!! URL::route('funds.edit',$data->id) !!}"><i class="fa fa-edit"></i> Sửa</a></li>
                                                <li><a class="delete" data_id="{{$data->id}}"><i class="fa fa-trash-o"></i> Xóa</button></li>
                                            @endif
                                        </ul>
                                    </div><!-- /btn-group -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <p>Không có dữ liệu</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->
            </div><!-- /panel-body -->
            <div class="page-right">
                {!! ($funds->appends(\Input::except('page'))->render()) !!}
            </div><!-- page-right -->
        </div><!-- /panel -->
    </div>
{!! Form::open(['method' => 'DELETE', 'route'=>['funds.delete'], 'id'=>'frm_delete']) !!}
{!! Form::hidden('id', 0, array('id' => 'fund_id')) !!}
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
                 $('#fund_id').val($(this).attr('data_id'));
                 $('#frm_delete').submit();
                 return true;
             });
         });
         $('#datetimepickers_date').datetimepicker({
             format: 'DD/MM/YYYY'
         });
    </script>
@stop

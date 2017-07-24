@extends('cms::layouts.cms')

@section('title','Lịch sử đóng quỹ hội')
@section('breadcrumbs','Lịch sử đóng quỹ hội')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Lịch sử đóng quỹ hội</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="page-right">
                {!! $funds_member->links() !!}
            </div><!-- page-right -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="bus-table">
                    <thead>
                    <tr>
                        <th class="text-center col-sm-2">Loại Thu/Chi</th>
                        <th class="text-center col-sm-2">Ngày</th>
                        <th class="text-center col-sm-2">Nội dung</th>
                        <th class="text-center col-sm-2">Số tiền</th>
                    </tr>
                     </thead>
                    @forelse ($funds_member as $data)
                     <tbody>
                        <tr>
                            <td class="text-center">{!! $fund_types[$data->type] !!}</td>
                            <td class="text-center">
                                @if($data->date != "0000-00-00 00:00:00") {!! \Carbon\Carbon::parse($data->date)->format('d-m-Y') !!} @endif</td>
                            <td class="text-center">{!! $data->content !!}</td>
                             <td class="text-center">{!! $data->amount !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <p>Không có dữ liệu</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div><!-- /table-responsive -->
        </div><!-- /panel-body -->
        <div class="page-right">
            {!! $funds_member->links() !!}
        </div><!-- page-right -->
        <a href="{{ Route('funds.index') }}" class="btn btn-danger btn-sm bounceIn pull-right" role="button">Đóng</a>
    </div><!-- /panel -->
@stop

@extends('cms::layouts.cms')

@section('title', 'Setting')
@section('breadcrumbs', 'Setting')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Setting</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <div class="page-right">

        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center col-sm-2">Tên</th>
            <th class="text-center col-sm-2">Giá trị</th>
            <th class="text-center col-sm-3">-</th>
        </thead>
        <tbody>
            @forelse ($setting_variables as $key=>$value)
                <tr>
                    <td class="text-center">{{ $value }}</td>
                    <td class="text-center">{{ Setting::get($key) }}</td>
                    <td class="text-center">
                        <a class="btn btn-success" href="{{ URL::route('settings.edit', $key) }}"><i class="fa fa-edit"></i> Sửa</a>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="3">
                <p>Không có dữ liệu</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">

    </div><!-- page-right -->
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop
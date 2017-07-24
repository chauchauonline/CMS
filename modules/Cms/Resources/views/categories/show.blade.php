@extends('cms::layouts.cms')

@section('title', 'Xem danh mục')
@section('breadcrumbs', 'Xem danh mục')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Xem danh mục</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tbody>
                <tr>
                    <th class="text-center">Tên danh mục</th>
                    <th> {{ $category->name }}</th>
                </tr>
                <tr>
                    <th class="text-center">Slug</th>
                    <th> {{ $category->slug }}</th>
                </tr>
                <tr>
                    <th class="text-center">Màu sắc</th>
                    <th><h4 style="color: #ffffff"><span class="ebtn" style="background-color: {{$category->color}}"> {{ $category->color}} </span></h4></th>
                </tr>
                <tr>
                    <th class="text-center">Trạng thái</th>
                    <th> {{ $category_status[$category->status] }}</th>
                </tr>
                <tr>
                    <th class="text-center">Mô tả</th>
                    <th> {{ $category->description}}</th>
                </tr>
                <tr>
                    <th class="text-center">Lần cập nhật cuối</th>
                    <th>{{ $category->updated_at }}</th>
                </tr>
            </tbody>
        </table>
    </div><!-- /table-responsive -->
    <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm bounceIn pull-right" role="button">Đóng</a>
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop

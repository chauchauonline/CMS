@extends('cms::layouts.cms')

@section('title','Đối Tác')
@section('breadcrumbs','Đối Tác')
@section('content')
    <div class="main-header clearfix">
        <div class="page-title">
            <h3 class="no-margin">Công ty: {{$company->name}}</h3>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
            {!! Form::open(['class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Tên:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name',$company->name,['class'=>'form-control', 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('orderby', 'Thứ tự:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('orderby',$company->orderby,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('source', 'Website:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('source',$company->source,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Mô tả:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('description',$company->description,['class'=>'form-control','readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Ảnh:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <?php $image = Modules\Cms\Entities\Image::find($company->image); ?>
                    <img style="width: 200px;" src="{!! asset('/uploads/partners/'.$image['name']) !!}" />
                    <input type="hidden" name="image_current" value="{!! $image['name'] !!}">
                </div>
            </div>
            <div class="pull-right">
                <a href="{!! URL::previous() !!}" class="btn btn-primary" role="button">Đóng</a>
            </div>
            {!! Form::close() !!}
        </div><!-- /panel-body -->
    </div><!-- /panel -->
@stop
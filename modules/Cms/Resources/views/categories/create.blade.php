@extends('cms::layouts.cms')

@section('title', 'Tạo danh mục mới')
@section('breadcrumbs', 'Tạo danh mục mới')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Tạo danh mục mới</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        {!! Form::open(['route' => 'categories.store', 'class' => 'form-horizontal']) !!}
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <label for="name" class="col-sm-2 control-label">Tên danh mục:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::text('name', null, ['class'=>'form-control', 'id' => 'name']) !!}
                    <p class='help-block'>{{ ($errors->has('name') ? $errors->first('name') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('slug')) ? 'has-error' : '' }}">
                <label for="slug" class="col-sm-2 control-label">Slug:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::text('slug', null, ['class'=>'form-control',  'id' => 'slug']) !!}
                    <p class='help-block'>{{ ($errors->has('slug') ? $errors->first('slug') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('status')) ? 'has-error' : '' }}">
                {!! Form::label('Status', 'Trạng thái:', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    @foreach ($category_status as $key=>$status)
                        @if($key == 0)
                            <label class="radio-inline">
                            {!! Form::radio('status', $key, true) !!} {{ $status }}
                            </label>
                        @else
                            <label class="radio-inline">
                            {!! Form::radio('status', $key) !!} {{ $status }}
                            </label>
                        @endif
                    @endforeach
                    <p class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('color')) ? 'has-error' : '' }}">
                <label for="slug" class="col-sm-2 control-label">Màu sắc:<span class="field-asterisk">*</span></label>
                <div class="col-sm-7">
                    {!! Form::text('color', null, ['class'=>'form-control', 'id' => 'color']) !!}
                    <p class='help-block'>{{ ($errors->has('color') ? $errors->first('color') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('description')) ? 'has-error' : '' }}">
                <label for="description" class="col-sm-2 control-label">Mô tả:</label>
                <div class="col-sm-7">
                {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
                <p class='help-block'>{{ ($errors->has('description') ? $errors->first('description') : '') }}</p>
                </div>
            </div>

            <div class="col-md-5 pull-right">
                <button type="submit" class="btn btn-success ">Lưu lại</button>
                <a href="{{ Route('categories.index') }}" class="btn btn-danger" role="button">Hủy</a>
            </div>
        {!! Form::close() !!}
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
<script type="text/javascript">
    generateSlugUrl = "{{ Route('categories.generate_slug') }}";
    $('#color').colorpicker({});

    $('#name').keyup(function(){
        var name = $(this).val();
        $.ajax({
            url: generateSlugUrl,
            type: "GET",
            data: {name:name},
            dataType: "JSON",
            success: function (response) {
                slug = response.data.slug;
                $('#slug').val(slug);
            },
            error: function(){
           }
        });
    });
</script>
@stop

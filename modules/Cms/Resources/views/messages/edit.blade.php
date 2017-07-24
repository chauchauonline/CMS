@extends('cms::layouts.cms')

@section('title', 'Soạn tin nhắn')
@section('breadcrumbs', 'Soạn tin nhắn')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Soạn tin nhắn</h3>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body">
        <div class='col-sm-7'>
        {!! Form::open(['route' => 'messages.send', 'class' => 'form-horizontal container-web']) !!}
            {!! Form::hidden('user_id', $user->id, ['id' => 'user_id']) !!}
            <div class="form-group {{ ($errors->has('subject')) ? 'has-error' : '' }}">
                {!! Form::label('subject', 'Email nhận:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::email('email', $message->email, ['class'=>'form-control']) !!}
                    <p class='help-block'>{{ ($errors->has('email') ? $errors->first('email') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('subject')) ? 'has-error' : '' }}">
                {!! Form::label('subject', 'Tiêu đề:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::text('subject', $message->subject, ['class'=>'form-control', 'id' => 'subject']) !!}
                    <p class='help-block'>{{ ($errors->has('subject') ? $errors->first('subject') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('message')) ? 'has-error' : '' }}">
                <label for="message" class="col-sm-3 control-label">Nội dung:</label>
                <div class="col-sm-7">
                {!! Form::textarea('message', $message->message, ['class'=>'form-control', 'id' => 'message']) !!}
                <p class='help-block'>{{ ($errors->has('message') ? $errors->first('message') : '') }}</p>
                </div>
            </div>

            <div class="form-group {{ ($errors->has('type')) ? 'has-error' : '' }}">
                {!! Form::label('type', 'Kiểu tin nhắn:', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    @foreach ($types as $key=>$val)
                         @if($val == $message->type)
                            <label class="radio-inline">
                            {!! Form::radio('type', $val, true) !!} {{ $val }}
                            </label>
                         @elseif($key == 0)
                            <label class="radio-inline">
                            {!! Form::radio('type', $val, true) !!} {{ $val }}
                            </label>
                        @else
                            <label class="radio-inline">
                                {!! Form::radio('type', $val) !!} {{ $val }}
                            </label>
                        @endif
                    @endforeach
                    <p class='help-block'>{{ ($errors->has('type') ? $errors->first('type') : '') }}</p>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-7">
                    <label>
                    <input type="checkbox" name="star" value="Yes">
                     <span class="custom-checkbox"></span>Thư quan trọng
                    </label>
                </div>
            </div>
            {!! Form::hidden('message_id', $message->id, ['id' => 'message_id']) !!}
            <div class="col-sm-10">
                <div class="col-sm-2 pull-right">
                    <a href="{{ Route('messages.index') }}" class="btn btn-danger btn-sm bounceIn btn-block" role="button">Hủy</a>
                </div>
                <div class="col-sm-2 pull-right">
                    <a class="btn btn-primary btn-sm bounceIn btn-block" id="saveToDraft" role="button">Lưu nháp</a>
                </div>
                <div class="col-sm-2 pull-right">
                    {!! Form::submit('Gửi', ['class' => 'btn btn-success btn-sm bounceIn btn-block']); !!}
                </div>
            </div>
        {!! Form::close() !!}
        </div>
    </div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
    <script type="text/javascript">
    <!--
        updateDraftUrl = "{{ Route('messages.updateDraft') }}";
    //-->
    </script>
    <script type="text/javascript">
        $("#saveToDraft").on('click', function(event){
            event.preventDefault();
            var id = <?php echo $message->id;?>;
            var user_id = $('#user_id').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            var type = $("input[type='radio']").val();
            if($("input[name='star']").is(":checked")){
                var star = $(this).val();
            } else {
                var star = 'No';
            }
            if(to == '') {
                alert('Phải nhập email nhận để lưu');
            } else {
                $.ajax({
                	url: updateDraftUrl,
                    type: "GET",
                    data: {id:id, user_id:user_id, email:email, subject:subject, message:message, type:type, star:star},
                    dataType: "JSON",
                }).done( function (response) {
                    if(response.result == 'ok') {
                        var link = baseUrl + "/messages";
                        window.location.href= link;
                    } else {

                    }
                }).fail( function() {

                });
            }
        });
    </script>
@stop
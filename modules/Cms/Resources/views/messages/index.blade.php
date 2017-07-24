@extends('cms::layouts.cms')

@section('title')
    {{ $title[$status] }}
@stop
@section('breadcrumbs')
    {{ $title[$status] }}
 @stop
@section('content')
    <div class="panel panel-default inbox-panel">
        <div class="panel-heading">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="Nhập từ khóa...">
                    <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div><!-- /input-group -->
        </div>
        <div class="panel-body">
            <label class="label-checkbox inline">
                <input type="checkbox" id="chk-all">
                 <span class="custom-checkbox"></span>
            </label>
            <a href="{{Route('messages.compose')}}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> Soạn</a>
            <a class="btn btn-sm btn-default delete_message"><i class="fa fa-trash-o"></i> Xóa</a>

            <div class="pull-right">
                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-refresh"></i></a>
                <div class="btn-group" id="inboxFilter">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Tất cả
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{Route('messages.index', ['status'=>$status, 'filter'=>'read'])}}">Đã đọc</a></li>
                        <li><a href="{{Route('messages.index', ['status'=>$status, 'filter'=>'unread'])}}">Chưa đọc</a></li>
                        <li><a href="{{Route('messages.index', ['status'=>$status, 'filter'=>'starred'])}}">Được gắn sao</a></li>
                        <li><a href="{{Route('messages.index', ['status'=>$status, 'filter'=>'not_starred'])}}">Không gắn sao</a></li>
                    </ul>
                </div><!-- /btn-group -->
            </div>
        </div>
        <ul class="list-group">
            @forelse($messages as $mes)
                <?php
                    $sender = Modules\Cms\Entities\User::find($mes->user_id);
                    $receiver  = Modules\Cms\Entities\User::find($mes->to);
                ?>
                <li class="list-group-item clearfix inbox-item">
                    <label class="label-checkbox inline">
                        <input type="checkbox" class="chk-item" name="chk-item[]" value="{{$mes->id}}">
                        <span class="custom-checkbox"></span>
                    </label>
                    @if($mes->star  == Config::get('constants.STARRED'))
                        <span class="starred starred_status" data-id="{{$mes->id}}"><i class="fa fa-star fa-lg"></i></span>
                    @else
                        <span class="not-starred not_starred_status" data-id="{{$mes->id}}"><i class="fa fa-star-o fa-lg"></i></span>
                    @endif
                    @if($status == 'Draft')
                        <a href="{{Route('messages.edit', $mes->id)}}">
                    @else
                        <a href="{{Route('messages.read', $mes->id)}}">
                    @endif
                         <span class="from">
                            @if($status == 'Sent' || $status == 'Draft')
                                @if($receiver)
                                    {{ $receiver->last_name.' '.$receiver->first_name }}
                                @endif
                            @else
                                @if($sender)
                                    {{ $sender->last_name.' '.$sender->first_name }}
                                @endif
                            @endif
                        </span>
                        <span class="detail">
                            @if($mes->status == 'Important')
                                <span class="label label-danger">Important</span>
                            @endif
                            {{$mes->subject}}
                        </span>
                    </a>
                    <span class="inline-block pull-right">
                        <span class="attachment"><i class="fa fa-paperclip fa-lg"></i></span>
                        <span class="time">
                            <?php
                                $time =  \Carbon\Carbon::parse($mes->created_at);
                                $now = \Carbon\Carbon::now();
                            ?>
                            @if($time->isToday())
                                {{ $time->format('H:i') }}
                            @else
                                {{ $time->diffForHumans($now) }}
                            @endif
                        </span>
                    </span>
                </li>
            @empty

            @endforelse
        </ul><!-- /list-group -->
        <div class="panel-footer clearfix">
            <div class="pull-left">{{ $messages->total() }} tin nhắn</div>
            <div class="pull-right">
                <span hidden>{{  $messages->appends(['status' => $status])->links() }} </span>
                <span class="middle" >Trang {{ $messages->currentPage()}} / {{$messages->lastPage()}}</span>
                <ul class="pagination middle">
                    <li class="disabled"><a href="#"><i class="fa fa-step-backward"></i></a></li>
                    <li><a href="{{ $messages->previousPageUrl() }}"><i class="fa fa-caret-left large"></i></a></li>
                    <li><a href="{{ $messages->nextPageUrl() }}"><i class="fa fa-caret-right large"></i></a></li>
                    <li  class="disabled"><a href="#"><i class="fa fa-step-forward"></i></a></li>
                </ul>
            </div>
        </div>
    </div><!-- /panel -->
@stop
@section('script')
    <script type="text/javascript">
    <!--
        addStarUrl  =  "{{ Route('messages.addStar') }}";
        removeStarUrl  = "{{ Route('messages.removeStar') }}";
        deleteMessageUrl = "{{ Route('messages.delete') }}";
    //-->
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".not_starred_status").on('click', function(){
                var message_id = $(this).attr('data-id');
                console.log("clicked");
                //change message to starred
                $.ajax({
                    url: addStarUrl,
                    type: "GET",
                    data: {message_id:message_id},
                    dataType: "JSON",
                }).done( function (response) {
                    console.log('starred');
                    // remove class not-starred
                    $(this).find('i').attr('class', 'fa fa-star fa-lg');
                    $(this).attr('class', 'starred starred_status');
                    location.reload();
                }).fail( function(){
                    alert('Đã xảy ra lỗi.');
                });
            });

            $(".starred_status").on('click', function(){
                var message_id = $(this).attr('data-id');
                console.log("clicked");
              //change message to starred
                $.ajax({
                    url: removeStarUrl,
                    type: "GET",
                    data: {message_id:message_id},
                    dataType: "JSON",
                }).done( function (response) {
                    console.log('unstarred');
                    // remove class not-starred
                    $(this).find('i').attr('class', 'fa fa-star-o fa-lg');
                    $(this).attr('class', 'not-starred not_starred_status');
                    location.reload();
                }).fail( function(){
                    alert('Đã xảy ra lỗi.');
                });
            });

            // Xóa message
            $(".delete_message").on('click', function(){
                // Lấy các mess được tick
                $("input[name='chk-item[]']").each(function(){
                    if($(this).is(":checked")){
                        var message_id = $(this).val();
                        console.log(message_id);
                        // Chuyển message sang trạng thái xóa
                        $.ajax({
                        	url: deleteMessageUrl,
                            type: "GET",
                            data: {message_id:message_id},
                            dataType: "JSON",
                        }).done( function (response) {
                            if(response.result == 'ok') {
                                console.log('Deleted');
                            } else {
                            }
                        }).fail( function(){
                            console.log('Error');
                        });
                    }
                });
                location.reload();
            });
        });
    </script>
@stop
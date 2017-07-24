@extends('cms::layouts.cms')

@section('title', 'Đọc tin nhắn')
@section('breadcrumbs', 'Đọc tin nhắn')

@section('content')
    <div class="panel panel-default inbox-panel">
        <div class="panel-heading">
            <h4>{{$message->subject}}</h4>
        </div>
        <div class="panel-body">
            <h5>Người gửi: {{$from_username}} ( <small> {{$from_email}} </small>)</h5>
            <h5>Tới: @if($receiver)
                        {{ $receiver->last_name." ".$receiver->first_name }}  <small>{{ "( ". $receiver->email ." )" }}</small>)
                    @else
                        <small>{{ "( ". $to_email . " )" }}</small>
                    @endif</h5>
            <p>Nội dung:</p><br>
            <p>{{$message->message}}</hp>
        </div>
        <div class="panel-footer clearfix">
        <a href="{{URL::previous()}}" class="btn btn-danger btn-sm BounceIn">Đóng</a>
        </div>
    </div><!-- /panel -->
@stop

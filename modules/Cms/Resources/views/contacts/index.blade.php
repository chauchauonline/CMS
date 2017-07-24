@extends('cms::layouts.cms')

@section('title', 'Tin nhắn liên hệ')
@section('breadcrumbs', 'Tin nhắn liên hệ')

@section('content')

<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Tin nhắn liên hệ</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
        {!! Form::open(array('method' => 'GET', 'route' => 'contacts.index', 'id'=>'form-filter')) !!}
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="form-group">
                {!! Form::select('status', array('' => '---Chọn trạng thái---')+$contact_status, app('request')->input('status'), ['class'=>'col-sm-4  form-control']) !!}
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-1">
              <div class="form-group">
                <button class="btn btn-info" type="submit">Tìm</button>
              </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="panel-body">
        <div class="page-right">
            {!! $contacts->links() !!}
        </div><!-- page-right -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <th class="text-center">Họ tên</th>
            <th class="text-center">Số điện thoại</th>
            <th class="text-center">Email</th>
            <th class="text-center">Nội dung tin nhắn</th>
            <th class="text-center">Ngày liên hệ</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">ID tin nhắn trả lời </th>
            <th class="text-center">-</th>
        </thead>
        <tbody>
            @forelse ($contacts as $contact)
            <tr>
                <td>{{ $contact->full_name }}</td>
                <td class="text-center">{{ $contact->mobile }}</td>
                <td class="text-center">{{ $contact->email }}</td>
                <td class="text-center">{{ $contact->message }}</td>
                <td class="text-center">{{ $contact->created_at }}</td>
                <td class="text-center">{{ $contact_status[$contact->status] }}</td>
                <td class="text-center">
                @if($contact->message_id)
                    <a href="{{ Route('messages.read', $contact->message_id) }}">{{ $contact->message_id }} <i class="fa fa-eye"></i></a>
                @endif
                </td>
                <td class="text-center">
                    @if($contact->status == Config::get('contants.UNREPLY'))
                        <a class="btn btn-success" href="{{ Route('messages.compose', ['contact_id' => $contact->id ,'email' => $contact->email ]) }}">
                            <i class="fa fa-edit"></i> Trả lời</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                <p>Không có tin nhắn liên hệ</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
        {!! $contacts->links() !!}
    </div><!-- page-right -->
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop

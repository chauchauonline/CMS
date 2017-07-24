@extends('cms::layouts.cms')

@section('title', 'Xem khoản thu/chi')
@section('breadcrumbs', 'Xem khoản thu/chi')

@section('content')
<div class="main-header clearfix">
  <div class="page-title">
    <h3 class="no-margin">Xem khoản thu/chi</h3>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center col-xs-2">Loại</th>
                    <th class="text-center col-xs-4">Nội dung</th>
                    <th class="text-center col-xs-2">Số tiền</th>
                    <th class="text-center col-xs-2">Ngày thu/chi </th>
                    <th class="text-center col-xs-2">Lần cập nhật cuối</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-center"> {{ $fund_types[$fund->type] }}</th>
                    <th> {{ $fund->content }}</th>
                    <th class="text-center"> {{ $fund->amount }}</th>
                    <th class="text-center">  @if($fund->date != "0000-00-00 00:00:00") {!! \Carbon\Carbon::parse($fund->date)->format('d-m-Y') !!} @endif</th>
                    <th class="text-center"> {{ $fund->updated_at }}</th>
                </tr>
            </tbody>
        </table>
    </div><!-- /table-responsive -->
    <br>
    @if($fund->type == '0')
    <h3>Danh sách thu quỹ</h3><br>
        {!! Form::open(array('method' => 'GET', 'route' => ['funds.show', $fund->id], 'id'=>'form-filter')) !!}
            <div class="col-sm-5 col-md-5 col-lg-3">
                <div class="form-group">
                {!! Form::text('keyword', app('request')->input('keyword'), ['class'=>'col-sm-5 form-control','placeholder' => 'Nhập từ khóa']) !!}
                </div>
            </div>
            <div class="col-sm-2 col-md-4 col-lg-1">
              <div class="form-group">
                <button class="btn btn-info" type="submit">Tìm</button>
              </div>
            </div>
        {!! Form::close() !!}
    <div class="page-right">
      {!! $members->links() !!}
    </div><!-- page-right -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center col-xs-2">Họ tên</th>
                    <th class="text-center col-xs-2">Điện thoại</th>
                    <th class="text-center col-xs-2">Email</th>
                    <th class="text-center col-xs-1">Trạng thái đóng quỹ</th>
                    <th class="text-center col-xs-2">Ghi chú</th>
                    @if($current_user->inRole('admin'))
                        <th class="text-center col-xs-1"></th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @forelse($members as $member)
                <tr>
                    <td> {{ $member->last_name." ".$member->first_name }}</td>
                    <td> {{ $member->mobile }}</td>
                    <td> {{ $member->email }}</td>
                    <td class='text-center'>
                        @forelse($fund_members as $fm)
                            @if($fm->member_id == $member->id)
                                Đã đóng
                            @endif
                        @empty
                        @endforelse
                    </td>
                    <td>
                        @forelse($fund_members as $fm)
                            @if($fm->member_id == $member->id)
                                {{ $fm->note }}
                            @endif
                        @empty
                        @endforelse
                    </td>
                    @if($current_user->inRole('admin'))
                        <td class="text-center">
                            <a data-target="#ModalEdit" data-toggle="modal" data_id="{{ $member->id }}" href="javascript:void(0)" class="btn btn-success ModalEdit">
                                                <i class="fa fa-edit"></i> Sửa</a>
                        </td>
                    @endif
                </tr>
            @empty

            @endforelse
            </tbody>
        </table>
    </div><!-- /table-responsive -->
    <div class="page-right">
      {!! $members->links() !!}
    </div><!-- page-right -->
    <!-- Begin ModalChangePermission -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content" id="modal-edit">
            <div class="modal-header">
              <button type="button" class="close close-ModalEdit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Chỉnh sửa trạng thái đóng quỹ</h4>
            </div><!-- modal-header -->
            <div class="modal-body">
                {!! Form::open(array('method' => 'POST', 'route' => 'fund_members.update', 'class' => 'form-horizontal form-border no-margin')) !!}
                    {!! Form::hidden('fund_id', $fund->id) !!}
                    {!! Form::hidden('member_id', null, ['id' => 'member_id']) !!}
                    <div class="form-group{{ $errors->has('pay_in') ? ' has-error' : null }}">
                        <label for="pay_in" class="col-sm-3 control-label">Trạng thái đóng quỹ:</label>
                        <div class="col-sm-7 modal-radio">
                            @foreach ($status as $key=>$label)
                                 <label class="radio-inline">
                                    @if($key == '0')
                                        {!! Form::radio('pay_in', $key, true) !!} {{ $label }}
                                    @else
                                        {!! Form::radio('pay_in', $key) !!} {{ $label }}
                                    @endif
                                </label>
                            @endforeach
                            <p class="help-block">{!! $errors->first('pay_in') !!}</p>
                        </div>
                    </div>
                    <div class="form-group {{ ($errors->has('note')) ? 'has-error' : '' }}">
                        <label for="note" class="col-sm-3 control-label">Ghi chú:</label>
                        <div class="col-sm-7">
                            {!! Form::textarea('note', null, ['class'=>'form-control', 'rows'=>3, 'id' => 'modal_note']) !!}
                            <p class='help-block'>{{ ($errors->has('note') ? $errors->first('note') : '') }}</p>
                        </div>
                    </div>
             </div><!-- modal-body -->
             <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu lại</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            {!! Form::close() !!}
            </div><!-- modal-footer -->

          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- Modal -->
    @endif
    <a href="{{ URL::previous() }}" class="btn btn-danger btn-sm bounceIn pull-right" role="button">Đóng</a>
</div><!-- /panel-body -->
</div><!-- /panel -->
@stop
@section('script')
<script type="text/javascript">
    findFundMemberUrl = "{{ Route('fund_members.find') }}";
    $(document).ready(function() {
        $(".ModalEdit").click(function(e){
            $('#member_id').val($(this).attr('data_id'));
            var member_id = $(this).attr('data_id');
            var fund_id = <?php echo $fund->id; ?>;
            // Lấy thông tin đóng quỹ của hội viên để fill vào modal
            $.ajax({
                url: findFundMemberUrl,
                type: "GET",
                data: {fund_id:fund_id, member_id:member_id},
                dataType: "JSON",
                success: function (response) {
                    if(response.data.fund_member){
                        $("#modal_note").val(response.data.fund_member.note);
                        $("input[name='pay_in']").filter('[value="1"]').prop('checked', true);
                    } else {
                        $("#modal_note").val("");
                        $("input[name='pay_in']").filter('[value="0"]').prop('checked', true);
                    }
                },
                error: function(){
               }
            });
        });
    });
</script>
@stop

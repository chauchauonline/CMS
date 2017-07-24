@extends('layouts.master')
@section('title', 'Liên hệ')

@section('content')
    <section class="newsdetail subpage region">
        <h2 class="textcenter fronttitle">Hãy tham gia cùng chúng tôi</h2>
    </section>

    <!-- About-->
    <div class="wauto contact-wrapper">
      <div class="centered">
        <h2 class="page-title">Liên hệ với chúng tôi</h2>
        <p class="lead">HÃY GỬI THÔNG TIN ĐỂ CHÚNG TÔI CÓ THỂ LIÊN LẠC VỚI BẠN SỚM NHẤT CÓ THỂ</p>
        <div class="contactFrm">
          <div class="col">
            <h3>Thông tin liên hệ</h3>
            <ul class="info">
              <li><i class="fa fa-map-marker" aria-hidden="true"></i>Tầng 2, Tòa nhà Dolphin Plaza Số 28 Trần Bình, Mỹ Đình, Từ Liêm, Hà Nội</li>
              <li><i class="fa fa-phone" aria-hidden="true"></i>+84 904 001 098 (Mr. Hiển - Trưởng ban truyền thông)</li>
            </ul>
          </div>
          <div class="col">
            {!! Form::open(['method'=> 'post', 'route' => 'site.save_contact', 'class' => 'form-contact', 'id' =>'contact-form'])!!}
                <fieldset>
                    <div>
                        <label for="full_name" class="contact_label">Họ và tên(<span class="text-red">*</span>)</label>
                        {!! Form::text('full_name', null, ['id' => 'form-name', 'placeholder' => 'Họ tên']) !!}
                        <p class="error"> {{ ($errors->has('full_name') ? "*".$errors->first('full_name') : '') }}</p>
                    </div>
                    <div>
                        <label for="email" class="">Email(<span class="text-red">*</span>)</label>
                        {!! Form::text('email', null, ['id' => 'form-email',  'placeholder' => 'Email']) !!}
                        <p class="error"> {{ ($errors->has('email') ? "*".$errors->first('email') : '') }}</p>
                    </div>
                    <div>
                         <label for="mobile" class="contact_label">Điện thoại(<span class="text-red">*</span>)</label>
                        {!! Form::text('mobile', null, ['id' => 'customer_phone',  'placeholder' => 'Số điện thoại', 'size' => '25', 'maxlength' =>'30' ]) !!}
                        <p class="error"> {{ ($errors->has('mobile') ? "*".$errors->first('mobile') : '') }}</p>
                    </div>
                    <div>
                        <label for="message" class="wide">Nội dung:</label>
                        {!! Form::textarea('message', null, ['id' => 'form-msg',  'placeholder' => 'Nội dung tin nhắn', 'rows' => '10']) !!}
                        <p class="error"> {{ ($errors->has('message') ? "*".$errors->first('message') : '') }}</p>
                   </div>
                </fieldset>
                <input type="submit" class="button button-small" value="Gửi tin nhắn">
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- About-->
@stop
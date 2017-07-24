@extends('layouts.master')
@section('title', 'Chi tiết hội viên: ' . $member->last_name." ".$member->first_name)

@section('content')
    <section class="newsdetail subpage region">
        <h2 class="textcenter fronttitle">Chi tiết hội viên: {{ $member->last_name." ".$member->first_name }}</h2>
    </section>
    <!--member-detail-->
    <div class="member-list member-detail">
      <div class="wauto">
        <div class="content">
          <div class="member-directory">
            <article>
              <div class="logo">
                    <?php $logo = Modules\Cms\Entities\Image::find($member->photo); ?>
                    @if($logo)
                        <a href="#"><img alt="{{ $member->last_name." ".$member->first_name }}" src="{{ Image::url($logo->thumbs,225,225,array('crop')) }}"></a>
                    @else
                         <a href="#"><img alt="{{ $member->last_name." ".$member->first_name }}" src="{{Config::get('constants.NONE_IMAGE_SOURCE')}}"></a>
                    @endif
              </div>
              <div class="panel detail-panel">
                  <h6 class="text-red">{{ $member->last_name." ".$member->first_name }}</h6>
                  <p>
                      <strong>Công ty:</strong> {{ $member->company_name }}<br>
                      <strong>Địa chỉ:</strong> {{ $member->address }}<br> <strong>Telephone:</strong> {{ $member->mobile }}<br>
                      <strong>Email:</strong> {{ $member->email }}<br>
                      <strong>Website:</strong> {{ $member->company_website}}<br><br>
                  </p>
                  <hr>
              </div>
              <p><strong><img alt="Giới thiệu" src="/img/intro.png" width="40" height="40"> Giới thiệu:</strong> {{ $member->bio }}</p><br>
              <p><strong><img alt="Nghề nghiệp" src="/img/career_icon.png" width="40" height="40"> Nghề nghiệp:</strong> {{ $member->career }}</p><br>
              <p><strong><img alt="Blog" src="/img/blog_icon.png" width="40" height="40"> Blog:</strong> {{ $member->blog }}</p><br>
              <p><strong><img alt="Facebook" src="/img/facebook.jpg" width="40" height="40">  Facebook:</strong> {{ $member->fb_url }}</p><br>
              <p><strong><img alt="Mong muốn" src="/img/wanted_icon.png" width="40" height="40"> Mong muốn ở hội:</strong> {{ $member->wanted }}</p>
            </article>
          </div>
        </div>
      </div>
    <!--Các thành viên cùng ngành nghề-->
    @if(isset($related_member))
        <section class="ceo_member">
            <div class="wauto">
                <!-- Slider main container -->
                <div class="swiper-container swiper-container-horizontal">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @forelse( $related_member as $mem)
                            <?php $avatar = Modules\Cms\Entities\Image::find($mem->photo); ?>
                            <div class="swiper-slide" style="width: 277.5px;">
                                <article>
                                    <figure>
                                        @if($avatar)
                                            <a href="{{ Route('site.members.details', $mem->id) }}">
                                                <img alt="{{$mem->last_name." ".$mem->first_name}}" src="{{ Image::url($avatar->thumbs,155,155,array('crop')) }}"" width="155" height="155">
                                            </a>
                                        @else
                                            <a href="{{ Route('site.members.details', $mem->id) }}">
                                                <img alt="{{$mem->last_name." ".$mem->first_name}}" src="{{Config::get('constants.NONE_IMAGE_SOURCE')}}" width="155" height="155">
                                            </a>
                                        @endif
                                    </figure>
                                    <a href="{{ Route('site.members.details', $mem->id) }}">
                                        <figcaption>
                                            <p class="fullname">{{ $mem->last_name." ".$mem->first_name }}</p>
                                            <p class="title"><strong>Chức vụ</strong> : {{ $mem->position }}</p>
                                            <p class="title"><strong>Liên hệ</strong> : {{ $mem->mobile }}</p>
                                        </figcaption>
                                    </a>
                              </article>
                            </div>
                        @empty

                        @endforelse
                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev swiper-button-disabled"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>
    @endif
    </div>
    <!--member-detail-->
@stop

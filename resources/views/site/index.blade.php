@extends('layouts.master')
@section('title', 'Việt Nam Bussiness Network')
@section('content')
    <!-- Begin hightlight -->
      <section class="hightlight region">
        <div class="banner">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide mrow" style="background-image:url(img/banner1.jpg);">
                <a href="javascript:;" title="">banner1</a>
              </div>
              <div class="swiper-slide mrow" style="background-image:url(img/banner2.jpg);">
                <a href="javascript:;" title="">banner2</a>
              </div>
              <div class="swiper-slide mrow" style="background-image:url(img/banner3.jpg);">
                <a href="javascript:;" title="">banner3</a>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <!-- End hightlight -->

    <!-- Begin Home about -->
    <section class="ceo_about">
      <div class="wauto">
        <h2 class="textcenter fronttitle">Giới thiệu hội</h2>
        <div class="wrapper">
          <div class="col-md-6 desc">
            <p>{!! \Illuminate\Support\Str::words(Setting::get('about_us', '') , $limit = 500, $end = '...') !!}</p>
          </div>
          <div class="col-md-6">
            <img src="{{ asset('img/about_us.gif') }}" alt="Về chúng tôi" />
          </div>
        </div>
      </div>
    </section>
    <!-- End Home about -->

    <!-- Begin News -->
      <section class="news region">
        <div class="wauto">
          <h2 class="fronttitle textcenter">Tin tức và sự kiện</h2>
          <div class="swiper-container swiper-container-horizontal">
            <ul class="swiper-wrapper econtent">
                @foreach($articles as $art)
                <?php
                    $image = Modules\Cms\Entities\Image::find($art->image_id);
                ?>
                <li class="pleft mcol100 swiper-slide ">
                    <div class="newconent">
                      <a href="{!! URL::route('site.articles.details',[$art->id])!!}">
                        @if($image)
                            <img src="{{ Image::url(asset($image->thumbs),336,200,array('crop')) }}" alt="{{ $art->title }}">
                        @else
                             <img src="" width="336" height="200" alt="{{ $art->title }}">
                        @endif
                      </a>
                      <div class="boxNew">
                        <h4>
                          <a href="{!! URL::route('site.articles.details',[$art->id])!!}" title="">{{ $art->title }}</a>
                        </h4>
                        <span class="time"> {{ \Carbon\Carbon::parse($art->updated_at)->format('d-m-Y') }}</span>
                        <article><p>{{ \Illuminate\Support\Str::words($art->brief, $limit = 15, $end = '...') }}</p></article>
                      </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="swiper-pagination"></div>
          </div>
        <div class="clearfix">
        </div>
      </section>
    <!-- End News -->

    <!-- Begin ceo member -->
    <section class="ceo_member">
      <div class="wauto">
        <h2 class="textcenter fronttitle">Hội viên</h2>
          <!-- Slider main container -->
          <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach($members as $member)
                <div class="swiper-slide">
                    <?php $avatar = Modules\Cms\Entities\Image::find($member->photo); ?>
                    <article>
                        <figure>
                            <a href="{{ Route('site.members.details', $member->id) }}">
                            @if($avatar)
                                <img src="{{  Image::url(asset($avatar->thumbs),155,155,array('crop')) }}" alt="{{$member->last_name." ".$member->first_name }}" width="155" height="155" />
                            @else
                                <img alt="{{$member->last_name." ".$member->first_name }}" src="{{ Config::get('constants.NONE_IMAGE_SOURCE') }}" width="155" height="155"/>
                            @endif
                            </a>
                        </figure>
                        <a href="{{ Route('site.members.details', $member->id) }}">
                            <figcaption>
                                <p class="fullname">{{$member->last_name." ".$member->first_name }}</p>
                                <p class="title"><strong>Chức vụ</strong> : {{ $member->position }}</p>
                                <p class="title"><strong>Liên hệ</strong> : {{ $member->mobile }}</p>
                            </figcaption>
                        </a>
                  </article>
                </div>
                @endforeach
            </div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
      </div>
    </section>
    <!-- End Home about -->
@stop

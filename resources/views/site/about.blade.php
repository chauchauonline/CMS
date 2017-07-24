@extends('layouts.master')
@section('title', 'Giới thiệu')
@section('content')
       <section class="newsdetail subpage region">
            <h2 class="textcenter fronttitle">Giới Thiệu</h2>
        </section>
<section class="aboutseta customer all-about subpage region">
    <!--Begin contentabout-->
  <div class="contentabout contentcustomer">
    <div class="wauto">
        <ul class="morestaff">
          @forelse($about as $data)
            <li>
              <div class="row">
                <div class="col col33 left-about mcol100">
                  <?php $image = Modules\Cms\Entities\Image::find($data->image_id); ?>
                   <a href="{!! route('site.show_page',$data->slug) !!}">
                        @if($image)
                            <img src="{{ Image::url(asset($image->thumbs),316,206,array('crop')) }}" alt="{{ $data->title }}">
                        @else
                             <img src="" width="336" height="200" alt="{{ $data->title }}">
                        @endif
                      </a>
                </div>
                <!--Begin informationsatff-->
                <div class="col col66 informationsatff informationcustomer mcol100">
                  <h3 class="title-info">{{ $data->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::words($data->abstract, $limit = 50, $end = '...') }}</p>

                   <a href="{!! route('site.show_page',$data->slug) !!}" title="Về chúng tôi" class="viewall viewall-ctm">Xem tất cả</a>
                </div>
                  <!--End informationsatff-->
              </div>
            </li>
          @empty
                <p>Không có bài viết để hiển thị</p>
          @endforelse
        </ul>
    </div>
  </div>
</section>
    <!--End ontentabout-->
@stop
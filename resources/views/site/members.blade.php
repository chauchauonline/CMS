@extends('layouts.master')
@section('title', 'Danh sách hội viên')

@section('content')
<section class="newsdetail subpage region">
  <h2 class="textcenter fronttitle">Danh sách hội viên</h2>
</section>

<!-- Sort Desc -->
  <div class="sort-desc centered">
    <div class="wauto">
        <p class="lead centered">
            Danh Sách Hội Viên
        </p>
    </div>
  </div>
<!-- Sort Desc -->

<!-- Member list-->
<div class="member-list">
  <div class="wauto">
    <div class="content">
        {!! Form::open(array('method' => 'GET', 'route' => 'site.members', 'id'=>'form-search-users', 'role'=>'search')) !!}
            {!! Form::text('keyword', app('request')->get('keyword'), ['class'=>'form-control', 'placeholder'=>'Nhập từ khóa tìm kiếm hội viên']) !!}
        {!! Form::close() !!}
        <div class="member-directory">
             @forelse( $members as $member )
                <?php $avatar = Modules\Cms\Entities\Image::find($member->photo); ?>
               <article>
                 <div class="logo">
                    @if($avatar)
                        <a href="{{ Route('site.members.details', $member->id) }}"><img alt="{{ $member->last_name." ".$member->first_name }}" src="{{ Image::url($avatar->thumbs,225,225,array('crop')) }}"></a>
                    @else
                        <a href="{{ Route('site.members.details', $member->id) }}"><img alt="{{ $member->last_name." ".$member->first_name }}" src="{{Config::get('constants.NONE_IMAGE_SOURCE')}}"></a>
                    @endif
                 </div>
                 <div class="panel">
                     <h6><a href="{{ Route('site.members.details', $member->id) }}">{{ $member->last_name." ".$member->first_name }}</a></h6>
                     <p>
                        <strong>Tên công ty: </strong>{{ $member->company_name }}<br>
                        <strong>Chức vụ: </strong> {{ $member->position }}<br>
                        <strong>Ngành nghề: </strong> {{ $member->career }}<br>
                        <strong>Điện thoại: </strong> {{ $member->mobile }}<br>
                        <strong>Email: </strong> {{ $member->email }}<br><br>
                        <a href="{{ Route('site.members.details', $member->id) }}" class="button">Xem hồ sơ đầy đủ</a>
                     </p>
                 </div>
               </article>
            @empty
                <p style="margin-left:7px"> Không tìm thấy hội viên</p>
            @endforelse
            <div class="more-member right">
                <!--<a href="#" class="button">Xem thêm hội viên</a> -->
            </div>
        </div>

        @if($members)
            @if($members->total() > $members_per_page)
            <nav class="pagination">
                <ul>
                    {!! with(new App\Pagination\Pagination($members->appends(\Input::except('page'))))->render() !!}
                </ul>
            </nav>
            @endif
        @endif
    </div>

    <aside class="sidebar">
        <div class="partner">
          <h2>Đối tác</h2>
          <ul>
              @foreach($company as $data)
              <?php $image = Modules\Cms\Entities\Image::find($data->image); ?>
                  <li><a href="{{ $data->source}}"><img alt="{{ $data->name }}" src="{{ Image::url($image->thumbs,300,170,array('crop')) }}"></a></li>
              @endforeach
          </ul>
        </div>
    </aside>
  </div>
</div>
<!-- Member list-->
@stop

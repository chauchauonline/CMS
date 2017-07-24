<header class="header region">
    <div class="wauto mrows  mtextcenter">
      <div class="topheader">
            {!! Form::open(array('method' => 'GET', 'route' => 'site.search', 'class'=>'searchform pright')) !!}
                <input type="text" class="searchinput searchenter" placeholder="Tìm kiếm" name="keyword">
                <input type="button" class="btnsearch">
            {!! Form::close() !!}
      </div>
      <a href="{{Route('site.index')}}" class="logo pleft">
        <img src="/img/VBN_logo.jpg" alt="">
      </a>

      <div class="pright templ">
        <div class="menu-mobile">
            <div class="menu-info">
              <div class="loged-profile">
                  @if($user = Sentinel::check())
                      <a href="javascript:void(0);" class="contact pright"><i class="fa fa-user" aria-hidden="true"></i></a>
                      <ul class="loged-submenu">
                         <li><a tabindex="-1" href="{{ URL::to('account') }}"><i class="fa fa-info-circle" aria-hidden="true"></i> Trang cá nhân</a></li>
                         <li><a tabindex="-1" href="{{ URL::to('logout') }}"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
                      </ul>
                  @else
                     <a href="{{ Route('login') }}" class="contact pright">Đăng nhập</a>
                  @endif
              </div>
              <a class="btn-menumobile hidepc mpright"></a>
              <a class="btn-closemenu hidepc mpright">x</a>
          </div>
          <ul class="mainmenu pright fontbold mw80" id="menu">
            <li><a href="{{ Route('site.index') }}/" title="Trang chủ">Trang chủ</a></li>
            <li class="parents"><a href="{!! URL::route('site.about') !!}" title="Giới thiệu">Giới thiệu</a>
              <ul class="submenu">
              <?php
                $page = DB::table('pages')->where('deleted_at','=',null)->where('status','=','1')->orderBy('order','ASC')->take(5)->get();
                ?>
                @foreach($page as $p)
                <li><a href="{!! URL::route('site.show_page',$p->slug) !!}" title="">{{ $p->name }}</a></li>
                @endforeach()
              </ul>
            </li>
            <li><a href="{{Route('site.members')}}" title="Danh sách hội viên">Hội viên</a></li>
            <li><a href="{{Route('site.articles')}}" title="Hoạt động">Hoạt động</a></li>
            <li><a href="{{ Route('site.contact') }}" title="">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </div>
</header>
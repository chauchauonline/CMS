<div id="top-nav" class="skin-6 fixed">
    <div class="brand">
        <a href="{{Route('site.index')}}" class="logo pleft">
        <img src="{{ Image::url('/img/VBN_logo.jpg',150,40,array('crop')) }}" alt="vbn.org.vn">
      </a>
    </div><!-- /brand -->
    <button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    @if($user = Sentinel::check())
        <ul class="nav-notification clearfix">
            <li class="profile dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <strong>{{ $user->username }}</strong>
                    <span><i class="fa fa-chevron-down"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="clearfix" href="#">
                            <img src="{{ asset('/cms/img/user.jpg') }}" alt="User Avatar">
                                <div class="detail">
                                    <strong>{{ $user->username }}</strong>
                                    <p class="grey">{{ $user->email }}</p>
                                </div>
                        </a>
                    </li>
                    <li><a tabindex="-1" href="{{ URL::to('account') }}" class="main-link"><i class="fa fa-edit fa-lg"></i> Trang cá nhân</a></li>
                    <li><a tabindex="-1" href="{{Route('users.edit', $user->id)}}" class="theme-setting"><i class="fa fa-cog fa-lg"></i> Cài đặt</a></li>
                    <li><a tabindex="-1" href="{{Route('users.index')}}" class="theme-setting"><i class="fa fa-group fa-lg"></i> Danh sách hội viên</a></li>
                    <li><a tabindex="-1" href="{{ Route('funds.index')}}" class="theme-setting"><i class="fa fa-money fa-lg"></i> Quỹ hội </a></li>
                    <li class="divider"></li>
                    <li><a tabindex="-1" href="{{ URL::to('logout') }}"><i class="fa fa-lock fa-lg"></i> Đăng xuất</a></li>
                </ul>
            </li>
        </ul>
    @else
        <ul class="nav-notification clearfix">
            <li><a tabindex="-1" href="{{ URL::to('login') }}"><i class="fa fa-lock fa-lg"></i> Đăng nhập</a></li>
        </ul>
    @endif
</div><!-- /top-nav-->
<aside class="fixed skin-6">
    <div class="sidebar-inner scrollable-sidebars">
        <div class="size-toggle">
            <a class="btn btn-sm" id="sizeToggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="btn btn-sm pull-right"  href="{{URL::to('logout')}}">
                <i class="fa fa-power-off"></i>
            </a>
        </div><!-- /size-toggle -->
        <div class="user-block clearfix">
            <img src="{{ asset('/cms/img/user.jpg') }}" alt="User Avatar">
            <div class="detail">
                <strong>{{ $user->username }}</strong><span class="badge badge-danger bounceIn animation-delay4 m-left-xs">0</span>
                <ul class="list-inline">
                    <li><a href="/account">Trang cá nhân</a></li>
                </ul>
            </div>
        </div><!-- /user-block -->
        <div class="search-block">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="search here...">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /search-block -->
        <div class="main-menu">
            <ul>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-users fa-lg"></i>
                        </span>
                        <span class="text">
                            Hội viên
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        @if($user->inRole('admin'))
                            <li><a href="{{ Route('users.create') }}"><span class="submenu-label">Thêm mới</span></a></li>
                             <li><a href="{{ Route('users.not_activated_members') }}"><span class="submenu-label">Hội viên mới đăng ký</span></a></li>
                        @endif
                        <li><a href="{{ Route('users.index') }}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-sitemap fa-lg"></i>
                        </span>
                        <span class="text">
                            Nhóm người dùng
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('roles.create') }}"><span class="submenu-label">Thêm mới</span></a></li>
                        <li><a href="{{ Route('roles.index') }}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-folder-open-o fa-lg"></i>
                        </span>
                        <span class="text">
                            Danh mục
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('categories.create')}}"><span class="submenu-label">Thêm mới</span></a></li>
                        <li><a href="{{ Route('categories.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-book fa-lg"></i>
                        </span>
                        <span class="text">
                            Bài viết
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('articles.create')}}"><span class="submenu-label">Thêm mới</span></a></li>
                        <li><a href="{{ Route('articles.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-file-text fa-lg"></i>
                        </span>
                        <span class="text">
                            Trang
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('pages.create')}}"><span class="submenu-label">Thêm mới</span></a></li>
                        <li><a href="{{ Route('pages.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-envelope fa-lg"></i>
                        </span>
                        <span class="text">
                            Liên hệ
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu inbox-menu" id="inboxMenu">
                        <li class="active">
                            <a href="{{ Route('contacts.index')}}">
                                <i class="fa fa-inbox fa-lg"></i>
                                <span class="m-left-xs">Tin nhắn liên hệ</span>
                                <span class="badge badge-success pull-right">{{ $unreply_contact }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Sent'])}}">
                                <i class="fa fa-envelope fa-lg"></i>
                                <span class="m-left-xs">Tin đã gửi</span>
                                <span class="badge badge-danger pull-right">{{$unread_sent}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Important'])}}">
                                <i class="fa fa-bookmark-o fa-lg"></i><span class="m-left-sm">Quan trọng</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Draft'])}}">
                                <i class="fa fa-pencil fa-lg"></i><span class="m-left-xs">Thư nháp</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Social'])}}">
                                <span class="m-left-sm">Xã hội</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('messages.index', ['status'=>'Junk'])}}"><span class="m-left-xs"> Tin rác </a></span>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Promosions'])}}"><span class="m-left-xs"> Quảng cáo </a></span>
                        </li>
                        <li>
                            <a href="{{Route('messages.index',['status'=>'Trash'])}}"><span class="m-left-xs"> Thùng rác </a></span>
                        </li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-users fa-lg"></i>
                        </span>
                        <span class="text">
                            Đối tác
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('companies.create')}}"><span class="submenu-label">Thêm mới</span></a></li>
                        <li><a href="{{ Route('companies.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-money fa-lg"></i>
                        </span>
                        <span class="text">
                            Quỹ hội
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('funds.create')}}"><span class="submenu-label">Thêm khoản thu/chi mới</span></a></li>
                        <li><a href="{{ Route('funds.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
                <li class="openable open">
                    <a href="#">
                        <span class="menu-icon">
                            <i class="fa fa-cog fa-lg"></i>
                        </span>
                        <span class="text">
                            Setting
                        </span>
                        <span class="menu-hover"></span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ Route('settings.index')}}"><span class="submenu-label">Danh sách</span></a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /main-menu -->
    </div><!-- /sidebar-inner -->
</aside>
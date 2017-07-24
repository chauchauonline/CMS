<?php
return [
    'article_status' => [
        0 => 'Chưa duyệt',
        1 => 'Đã duyệt',
    ],
    'RECORD_PER_PAGE' => 20,
    'GENDER' => [
        0 => 'Không xác định',
        1 => 'Nam',
        2 => 'Nữ',
        9 => 'Không được áp dụng',
    ],
    'PAGE_STATUS' => [
        1   => 'Hiển thị',
        2   => 'Ẩn',
    ],
    'ENUM_COMPILER'  => [
        'php'   => 'PHP',
        'blade' => 'Blade',
        'twif'  => 'Twif',
        'none'  => 'None',
    ],
    'NONE_IMAGE_SOURCE' => "/cms/img/none_image.jpg",
    'MESSAGE_STATUS' => [
        'Draft' => 'Tin nháp',
        'Inbox' => 'Hộp thư đến',
        'Sent' => 'Thư đã gửi',
        'Trash' => 'Thùng rác',
        'Junk' => 'Tin rác',
        'Important' => 'Thư quan trọng',
        'Promosions' => 'Quảng cáo',
        'Social' => 'Xã hội',
    ],
    'MESSAGE_TYPE' => [
        'System',
        'Admin',
        'User',
    ],
    'UNREAD' => 0,
    'READ'  => 1,
    'FROM_EMAIL' => env('MAIL_USERNAME'),
    'FROM_USERNAME' => env('MAIL_NAME'),
    'STARRED'  => 'Yes',
    'NOT_STARRED'  => 'No',
    'CONTACT_STATUS'    => [
        0   => 'Chưa trả lời',
        1   => 'Đã trả lời',
    ],
    'UNREPLY'  => 0,
    'REPLIED'  => 1,
    'ARTICLES_PER_PAGE' => 5,
    'MEMBERS_PER_PAGE' => 5,
    'FRONT_END' => env('DOMAIN'),
    'PERMISSIONS' => [
        'admin' => 'Admin',
        'member' => 'Hội viên',
    ],
    'ROLE_DEFAULT' => 'member',
    'PERMISSION_DEFAULT' => 'member',
    'CATEGORY_STATUS' => [
        0   => 'Ẩn',
        1   => 'Hiển thị',
    ],
    'SHARE_INFO'  => [
        0   => 'Không',
        1   => 'Có'
    ],
    'FUND_TYPE'  => [
        0   => 'Thu',
        1   => 'Chi'
    ],
    'PAY_IN_STATUS' => [
        0   => 'Chưa đóng',
        1   => 'Đã đóng',
    ],
    'SETTING_VARIABLES' => [
        'maps_location' => 'Địa chỉ trên bản đồ',
        'about_us'      => 'Giới thiệu hội',
    ],
    'LOGIN_URL' => env('APP_URL').'/login',
];
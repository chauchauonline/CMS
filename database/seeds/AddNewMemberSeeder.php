<?php

use Illuminate\Database\Seeder;

class AddNewMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'first_name' =>'Thạch',
                'last_name' => 'Đỗ Văn',
                'email'     => 'thachdv@gmail.com',
                'mobile' =>'0983883102',
                'permissions' => ['member'=> true]
            ],
            [
                'first_name' =>'Tuyết',
                'last_name' => 'Vũ Ánh',
                'email'     => 'tuyetva@gmail.com',
                'mobile' =>'0984162727',
                'permissions' => ['member'=> true]
            ],
            [
            'first_name' =>'HIỀN( MÍT )',
            'last_name' => 'NGUYỄN THỊ',
            'email'     => 'hiennt@gmail.com',
            'mobile' =>'0989911999',
            'permissions' => ['member'=> true]
            ],
            [
            'first_name' =>'KIÊN',
            'last_name' => 'PHẠM',
            'email'     => 'kien.pham@gmail.com',
            'permissions' => ['member'=> true]
            ],
            [
            'first_name' =>'QUANG( HƯNG YÊN)',
            'email'     => 'quang@gmail.com',
            'permissions' => ['member'=> true]
            ],
            [
            'first_name' =>'THỤ',
            'last_name' => 'NGUYỄN',
            'email'     => 'thu.nguyen@gmail.com',
            'permissions' => ['member'=> true]
            ],
            [
            'first_name' =>'TRƯỜNG PHÁT',
            'email'     => 'truong.phat@gmail.com',
            'permissions' => ['member'=> true]
            ],
        ];
        foreach ($data as $item){
            $item['password'] = '123456';
            $user = Sentinel::registerAndActivate($item);
            $role = Sentinel::findRoleBySlug('member');
            $role->users()->attach($user);
        }
    }
}

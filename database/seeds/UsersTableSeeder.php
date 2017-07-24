<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_users')->truncate();
        // Create Admin Role
        $role1 = [
                'name' => 'Admin',
                'slug' => 'admin',
        ];
        $adminRole = Sentinel::getRoleRepository()->createModel()->fill($role1)->save();

        // Create User Role
        $role2 = [
                'name' => 'Member',
                'slug' => 'member',
        ];
        $userRole = Sentinel::getRoleRepository()->createModel()->fill($role2)->save();

        // Create user with admin-role
        $admin_data = [
                'email'    => 'admin@example.com',
                'password' => 'admin123',
                'permissions' => [
                        'admin' => true,
                ]
        ];

        $admin = Sentinel::registerAndActivate($admin_data);
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($admin);
    }
}

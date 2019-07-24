<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name' => 'super_admin',
            'email' => 'admin'.'@admin.com',
            'password' => bcrypt('admin@admin.com'),
            'img'	=> '',
            'desc'  => '博客后台默认用户，拥有最高的权限',
        ]);
    }
}

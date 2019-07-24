<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'super_admin';
        $role->display_name = '超级管理员';
        $role->description = '拥有最大的权限，可以对后台所有功能进行管理 能对所有管理员进行管理';
        $role->save();


        $role = new Role();
        $role->name = 'default';
        $role->display_name = '普通角色';
        $role->description = '用户注册时默认给与的一个角色，除了可以看首页没有任何权限';
        $role->save();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class RoleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $search = [];

        if (strlen($name=$request->name) > 0) {
           $where[] = ['name','like', '%'.$name.'%'];
           $search['name'] = $name;
        }


        $list = Role::where($where)
                    ->select('name','id','display_name','description','updated_at')
                    ->paginate(10);

        return view('admin.role.list',compact('list','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role();

        $permissions = Permission::all();

        foreach ($permissions as $key ) {
            $permissionsList[$key->type][] = $key;
       }

        return view('admin.role.edit',compact('role','permissions','permissionsList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles|max:255',
            'display_name' => 'required',
         ]);
        
        $permissions = $request->input('permission');

        if (is_null($permissions)) {
            return $this->error('至少选择一个权限');
        }
        
        $owner = new Role();
        $owner->name = $request->input('name');
        $owner->display_name = $request->input('display_name');
        $owner->description = $request->input('description');
       
        if (!$owner->save()) {
            $this->recordLog(2,'添加一个新的角色失败',0);//记录到日志
            return $this->error('添加角色失败');
            
        }


        foreach ($permissions as $k => $v) {
           $owner->attachPermission($v);
        }

        $this->recordLog(2,'添加一个新的角色成功',1);//记录到日志
        return $this->success('添加角色成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       if (!intval($id)) {
          return $this->error('非法参数');
       }
       if ($id == 1) {
           return $this->error('不能对超级管理员进行修改');
       }
       if(empty($role=Role::find($id))){
           return $this->error('获取数据失败');
       }

       $permissions = Permission::all();//查找出所有权限

       $permissionsList = [];
       foreach ($permissions as $key) {
          $permissionsList[$key->type][] = $key;
       }


       $role_permissions = array_column(json_decode(json_encode(DB::table('permission_role')->where('role_id',$id)->get()),true),'role_id','permission_id');//查找出该角色拥有的

       return view('admin.role.edit',compact('role','permissionsList','role_permissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
         ]);
        
        if (is_null($permissions = $request->input('permission'))) {
            return $this->error('至少选择一个权限');
        }

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');

        DB::beginTransaction();

        if (!DB::table('permission_role')->where('role_id',$id)->get()->isEmpty()) {
            if (!DB::table('permission_role')->where('role_id',$id)->delete()) {
                DB::rollBack();
                return $this->error('修改角色权限时失败，请联系管理员');
            }
        }

        foreach ($permissions as $k => $v) {
           $role->attachPermission($v);
        }
        
        if (!$role->save()) {
            $this->recordLog(3,'修改角色为'.$role->name.'角色失败',0);//记录到日志
            return $this->error('修改角色失败');
        }
        DB::commit();

        $this->recordLog(3,'修改角色为'.$role->name.'角色成功',1);//记录到日志
        return $this->success('修改角色成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

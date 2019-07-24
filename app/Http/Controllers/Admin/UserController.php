<?php

namespace App\Http\Controllers\Admin;

use App\Models\OperationLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use DB;

class UserController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $where  =  [];
        $search =  [];

        //筛选用户名
        if ($name=$request->name) {
           $where[] = ['name','like', '%'.$name.'%'];
           $search['name'] = $name;
        }
        //筛选角色
        if (strlen($roleType=$request->role) > 0 && $roleType != -1) {
            $where[] = ['role_id',$roleType];
            $search['role'] = $roleType;
        }

        //获取用户列表
        $list = User::select('id','name','email','created_at','updated_at')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->where($where)
                    ->paginate(10);

        //获取角色列表
        $role = Role::select('display_name','id')
                    ->get();

        return view('admin.user.list',compact('list','search','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        $role = Role::select('id','display_name','name')
                    ->get();

        return view('admin.user.edit',compact('user','role'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
          ]);

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->desc = $request->input('desc');
        if ($request->file('img')) {
            try {
                if (!$path = $this->uploadImageData('img',['png','jpeg','jpg'],'admin/user')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $user->img = $path;
        }

        if (!$user->save()) {
            $this->recordLog(2,'添加一个新的用户',0);
            return $this->error('添加用户失败');
        }   

        foreach ($request->input('role') as $key => $value) {
             $user->attachRole($value);
        }
       
        $this->recordLog(2,'添加一个新的用户',1);//记录日志
        return $this->success('添加用户成功');
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
       if (empty($user=User::find($id))) {
           return $this->error('获取数据失败');
       }

       $role = Role::select('id','display_name','name')
                    ->get();

       return view('admin.user.edit',compact('user','role'));
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
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        $user = User::find($id);

        if (is_null($user)) {
            return $this->error('获取数据失败');
        }

        if (is_null($request->input('password'))) {

            $this->validate($request, [
                'name' => 'required|string|max:255',
                'role'     => 'required'
            ]);

            if (!intval($request->input('role'))) {
               return $this->error('获取角色id失败');
            }

            $user->name = $request->input('name');
            $user->desc = $request->input('desc');

            if ($request->file('img')) {
                try {
                    if (!$path = $this->uploadImageData('img',['png','jpeg','jpg'],'/admin/user')) {
                       return $this->error('图片保存失败');
                    }
                    } catch (\Exception $e) {
                        return $this->error($e->getMessage());
                    }
                     $user->img = $path;
             }
            if (!$user->save()) {
                $this->recordLog(3,'修改邮箱为'.$user->email.'用户',0);//记录到日志
                return $this->error('修改用户信息失败');
            }            


            if($user->roles->isEmpty()){
               foreach ($request->input('role') as $key => $value) {
                        $user->attachRole($value);
                  }
            }else{
               DB::table('role_user')->where('user_id',$id)->delete();
               foreach ($request->input('role') as $key => $value) {
                        $user->attachRole($value);
                  }
            }               

            $this->recordLog(3,'修改邮箱为'.$user->email.'用户',1);//记录到日志
            return $this->success('修改用户信息成功');
            

        }else{
             $this->validate($request, [
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:6|confirmed',
                    'role'     => 'required'
             ]);

            if (!intval($request->input('role'))) {
               return $this->error('获取角色id失败');
            }

            $user->name = $request->input('name');
            $user->desc = $request->input('desc');
            $user->password = bcrypt($request->input('password'));

            if ($request->file('img')) {
            try {
                if (!$path = $this->uploadImageData('img',['png','jpeg','jpg'],'uploads/user/')) {
                   return $this->error('图片保存失败');
                }
                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
                 $user->img = $path;
             }
          
            if (!$user->save()) {
                $this->recordLog(3,'修改邮箱为'.$user->email.'用户',0);//记录到日志
                return $this->error('修改用户失败');
            }

            if($user->roles->isEmpty()){
               foreach ($request->input('role') as $key => $value) {
                        $user->attachRole($value);
                  }
            }else{
               DB::table('role_user')->where('user_id',$id)->delete();
               foreach ($request->input('role') as $key => $value) {
                        $user->attachRole($value);
                  }
            }

            $this->recordLog(3,'修改邮箱为'.$user->email.'用户',1);//记录到日志
            return $this->success('修改用户信息成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!intval($id)) {
             return $this->ajaxResponse('500','非法参数');
        }

        if (!$res=User::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        $this->recordLog(4,'删除用户',1);//记录到日志
        return $this->ajaxResponse('200','删除成功');

    }
}

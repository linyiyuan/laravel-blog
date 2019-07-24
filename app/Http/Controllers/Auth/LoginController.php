<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\OperationLog;
use App\Http\Controllers\Admin\Common\CommonController;
use Session;
use App\User;
use App\Role;

class LoginController extends CommonController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '';
    
    protected function redirectTo()
    {
        //获取用户角色
        $user = User::find(Auth::user()->id);

        $str = '';
        foreach ($user->roles as $role) {
           $str .= $role->display_name.',';
        }

        //记录登录日志报告
        $log = new OperationLog();//获取登录日志对象
        $log->username = Auth::user()->name;
        $log->role = rtrim($str,',');
        $log->ip = $this->getIp();
        $log->result = 1;
        $log->operate = 1;
        $log->detail = Auth::user()->name.'在'.date('Y-m-d H:i:s',time()).'登录后台管理系统';
        
        if ($log->save()) {
             return '/admin/index';
        }else{
            Session::flash('message', ['code' => 500, 'data' => '记录登录日志失败']);
            return '/admin/index';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Route,URL,Auth,Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前控制器
        $actions=explode('\\', \Route::current()->getActionName());
            //或$actions=explode('\\', \Route::currentRouteAction());
        $modelName=$actions[count($actions)-2]=='Controllers'?null:$actions[count($actions)-2];
        $func=explode('@', $actions[count($actions)-1]);
        //获取当前控制器
        $controllerName=$func[0];
        //获取当前方法
        $actionName=$func[1];


        //获取当前用户信息
        $user = $request->user();

        //判断是否是超级管理员
        if ($user->hasRole('super_admin')) {
             return $next($request);
        }

        //判断是否有权限
        if ($user->can($controllerName)) {
            return $next($request);
        }

        // 没有权限则返回到403页面
        return response()->view('admin.error.403');
        // return $next($request);
    }
}

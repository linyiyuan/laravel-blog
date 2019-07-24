<?php

namespace App\Http\Controllers\Home;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Common\BaseController;

class LoginController extends BaseController
{
   public function index(Request $request)
   {
      //跳转地址
      if (isset($_SERVER['HTTP_REFERER'])) {
        $redirect_url = $_SERVER['HTTP_REFERER'];
        return view('home.login',compact('redirect_url'));
      };
      $redirect_url = '/blog';

      return view('home.login',compact('redirect_url'));
   		
   }

   public function doLogin(Request $request)
   {
   		$userPhone = $request->userinp;//获取用户手机号
      $userPass = $request->password; //获取用户输入的手机验证码

      // return $this->errorReturn(500,Hash::make($userPass));

      //手机跟密码验证码
    	if (empty($userPhone) && empty($userPass)) {
    		return $this->errorReturn('500','手机号码跟密码不能为空');
    	}

      //获取登录用户信息
      if (is_null($visitor = Visitor::where('phone',$userPhone)->first())) {
        return $this->errorReturn('500','该手机号码不存在');
      }

      //验证用户密码
      if (Hash::check($userPass, $visitor->userpass)) {
          //生成登录token
          $token = Hash::make($userPhone.time());
          $visitor->_token = $token;
          if ($visitor->save()) {
            return $this->successReturn(200,$token);
          }
          return $this->errorReturn('500','登录失败');
          
      }

      return $this->errorReturn(500,'登录失败 密码错误');

   }
}

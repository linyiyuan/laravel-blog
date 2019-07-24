<?php

namespace App\Http\Controllers\Home;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Home\Common\BaseController;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
    	$userPhone = $request->phone;//获取用户手机号
        $userCaptcha = $request->code; //获取用户输入的手机验证码

        $token = md5($userPhone.$userCaptcha.date('Y-m-d', time()));

    	$captrue = Redis::get($userPhone.'_captcha');

    	if (empty($userPhone) && empty($userCaptcha)) {
    		return $this->errorReturn('500','手机号码跟验证码不能为空');
    	}
    	if (!isset($captrue)) {
    		return $this->errorReturn('500','请重新发送验证码');
    	}

    	if ($captrue != $userCaptcha) {
    		return $this->errorReturn('500','手机验证码输入错误');
    	}

        if (!is_null(Visitor::where('phone',$userPhone)->first())) {
            return $this->errorReturn('500','该手机号码已经存在');
        }

        $visitor = new Visitor();

        $visitor->phone = $userPhone;
        $visitor->userpass = Hash::make($userPhone);
        $visitor->username = '匿名用户';
        $visitor->_token = $token;
        $visitor->lastlogintime = time();
        $visitor->status = 1;
        $visitor->lastloginip = $_SERVER['REMOTE_ADDR'];
        $num = rand(1,8);
        $visitor->img = '/home/article/images/avatar'.$num.'.jpeg';

        if (!$visitor->save()) {
            return $this->errorReturn('500','注册失败');
        }
    	
        return $this->successReturn('200',$token);
    }
}

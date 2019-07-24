<?php

namespace App\Http\Controllers\Api;

use Captcha;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Hashing\BcryptHasher as Hasher;
use App\Http\Controllers\Api\Common\BaseController;

class CodeCaptchaController extends BaseController
{	

	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-19
	 * @获取图形验证码
	 * @param     Request     $request [description]
	 * @return    [string]               [验证码图片]
	 */
    public function getCode(Request $request)
    {	

    	// //获取验证码图片
    	$img = captcha_img();
        
    	if(!isset($img)){
    		return $this->errorReturn(500,'请求验证码错误');
    	}

    	return $this->successReturn(200,$img);
    }

    public function checkCode(Request $request)
    {
    	$captcha = $request->captcha;//获取用户输入验证码

        if (!isset($captcha)) {
            return  $this->errorReturn(500,'获取用户输入验证码错误');
        }

        $rules = [
            'captcha' => 'required|captcha',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorReturn(500,'验证码输入错误');
        }else{
           return $this->successReturn(200,true);
        }
        

    	return $this->errorReturn(500,false);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Visitor;
use \Yunpian\Sdk\YunpianClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\Common\BaseController;

class PhoneCaptchaController extends BaseController
{
	private $apikey; //云片的apikey;
	private $mobile; //你的发送短信手机；
	private $text;

	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-19
	 * @初始化操作
	 */
	public function __construct()
	{
		$this->apikey = 'dfcf4379524e43c2d084791531281034';
		$this->text = '【狗达与佩唲】您的验证码是1234';
	}

	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-19
	 * @code   403  [表示还处于发送短信之后的120秒内]
	 * @code   405  [表示已经连续发送三次信息以上，需等待30分钟后执行]
	 * @code   200  [成功发送短信]
	 * @code   500  [发送短信失败]
	 * @发送短信通知
	 */
    public function getPhoneCode(Request $request)
    {
    	header("Content-Type:text/html;charset=utf-8");
    	
    	$phone = $request->phone; //获取用户输入的手机号码

    	$checkPhone = preg_match('/^1[34578]\d{9}$/', $phone);
		
		//验证手机号格式
		if (!$checkPhone) {
    		return $this->errorReturn(500,'手机格式错误');
    	}   

    	if (!is_null(Visitor::where('phone',$phone)->first())) {
    		return $this->errorReturn(500,'该手机号码已经注册');
    	}
    	if (Redis::get($phone.'_time')) {
    		//判断是否已经在120秒内发送过信息如果有发送则返回时间
    		$time = Redis::ttl($phone.'_time');
    		return $this->errorReturn(403,$time);
    	}elseif (Redis::get($phone) == 3) {
    		//判断同个手机号码是否已经发送过三次短信
    		return $this->errorReturn(405,'你已经发送三次短信，请30分钟后重试');
    	}

    	//生成验证码
    	$captcha = '';
    	for ($i=0; $i <5 ; $i++) { 
    		$number = mt_rand(0,9);
    		$captcha .= $number;
    	}

  //   	// 初始化client,apikey作为所有请求的默认值
		// $clnt = YunpianClient::create($this->apikey);

		// //发送短信验证码
		// $param = [YunpianClient::MOBILE => $phone,YunpianClient::TEXT => '【云片网】您的验证码是'.$captcha];
		// $r = $clnt->sms()->single_send($param);

		// if($r->isSucc()){
			//判断Redis是否存在于Redis如果存在就加一，不存在加加入缓存
			if (Redis::get($phone)) {
				Redis::incr($phone);
			}else{
				Redis::set($phone,'1');//将用户手机号码存入到redis中
				Redis::expire($phone,1800);//限制时间
			}
			
			Redis::setex($phone.'_time',120,$phone);//开始计时
			Redis::set($phone.'_captcha',$captcha);//讲验证码保存到redis中

		    return $this->successReturn(200,$captcha);
		// }

		return $this->errorReturn(500,'发送验证码失败，请稍后重试');

    }

}

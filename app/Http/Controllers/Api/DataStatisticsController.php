<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\Common\BaseController;

class DataStatisticsController extends BaseController
{
	protected  $redis;

	public function __construct()
	{
		$redis = Redis::connection('blog_visits');
		$this->redis = $redis;
	}

    public function getData()
    {
    	$beforeTime = [];//用来储存当前七天的访问量
    	$nowTime = date('m/d',time());//获取当前时间
    	$time = strtotime($nowTime);//获取当前零点时的时间戳

    	$beforeTime[0] = $nowTime;
   
    	$oneDayTime = 86400;
    	for ($i=1; $i < 7; $i++) { 
    		$beforeTime[$i] = date('m/d',$time-($i*$oneDayTime));
    	}

    	$dataStatistics = [];
    	$year = date('Y',time());

    	foreach ($beforeTime as $key => $value) {
    		$dataTime = date('Y-m-d',strtotime($value));

    		$dataStatistics[$dataTime] = $this->redis->hlen($dataTime);
    	}

    	$dataStatistics = array_reverse(array_values($dataStatistics));
    	$beforeTime = array_reverse($beforeTime);


    	return $this->successReturn('200',['dataStatistics' => $dataStatistics ,'dataTime' => $beforeTime]);
    }	
}

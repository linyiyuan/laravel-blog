<?php

namespace App\Http\Controllers\Admin;

use Ip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Admin\Common\CommonController;

class DataStatisticsController extends Controller
{
    public function pv(Request $request)
    {
    	$redis = Redis::connection('blog_visits');//连接redis数据库

    	$allDate = $redis->keys('*');//获取到所有访问记录

    	arsort($allDate);//数组降序
    	
    	if (!empty($request->date)) {
    		$nowDate = $request->date;
    	}else{
    		$nowDate = date('Y-m-d',time());
    	}

    	$dataStatistics = $redis->hgetall($nowDate);//获取所有访问ip

    	$pv = [];
    	foreach ($dataStatistics as $key => $value) {
    		$pv[$key]['ip'] = $key;
    		$pv[$key]['times'] = $value;

    		$ipAddress = Ip::find($key);//获取ip地理信息
    		$pv[$key]['address']= $ipAddress[0].'-'.$ipAddress[1].'-'.$ipAddress[2];
    		if (!empty($ipAddress[4])) {
    			$pv[$key]['code'] = $ipAddress[4];
    		}else{
    			$pv[$key]['code'] = '-';
    		}

    	}
        
    	return view('admin.data_statistics.pv',compact('allDate','pv','nowDate'));
    }
}

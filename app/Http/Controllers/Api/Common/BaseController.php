<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class BaseController extends Controller
{

    protected  $params = [];
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-04-16
	 * @处理url路径
	 * @param     [type]      $url [description]
	 */
    public function getFullUrl($url)
    {
        if (!$url) {
            return '';
        }
        if (strtolower(substr($url, 0, 4)) == 'http') {
            return $url;
        }
        $cdn = \Config::get('app.cdn_url');
        if (strtolower(substr($cdn, 0, 4)) == 'http') {
            return $cdn . $url;
        }
        return url($url);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-16
     * @成功时ajax响应
     */
    protected function successReturn($code,$data)
    {
    	return response()->json([
        		'code' => 200,
        		'msg'  => 'success',
        		'data' => $data,
        	]);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-16
     * @失败时响应
     */
    protected function errorReturn($code,$data)
    {

        return response()->json([
        	'code' => $code,
        	'msg'  => 'error',
        	'data' => $data,

        ]);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-16
     * 对象转为数组
     */
    public function toArray($data = '')
    {
        return  json_decode(json_encode($data),true);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-17
     * @得到当前日期的零点时间
     */
    public function getNowTime()
    {
         $todayTime = date('Y-m-d',time());//获取当天时间
         $todayTime = strtotime($todayTime);

         return $todayTime;
    }

    public function checkUrl($arr,$img){
           foreach ($arr as $key => $value) {
               $url = 'http://'.$value.':8099'.$img;
               if (@file_get_contents($url)) {
                  return $url;
               }
           }
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-06-06
     * 用来判断远程文件是否存在
     */
    public function getUrlExists($url){
        if (!isset($url)) {
            return '请输入要验证的url';
        }
        $ch = curl_init(); 
        $timeout = 10; 
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_HEADER, 1); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
        $contents = curl_exec($ch);
        if(preg_match("/404/", $contents)){
            return false;
        }else{
            return true;
        }
    }

    protected function getParamByKey($key, $default = '') {
        return isset($this->params[$key]) ? $this->params[$key] : $default;
    }
}

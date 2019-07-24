<?php 
/*
	全局加载函数，整个框架都可以调用
 */
use App\Models\Visitor;
use Illuminate\Support\Facades\Cookie;

function userInfo()
{
	$userInfo = Cookie::get('userinfo');

	if (!$userInfo) {
		return false;
	}

    //	解密
    $userInfo = json_decode($userInfo,true);

	return $userInfo;
}






?>
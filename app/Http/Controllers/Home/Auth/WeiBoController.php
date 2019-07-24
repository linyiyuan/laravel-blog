<?php

namespace App\Http\Controllers\Home\Auth;

use App\Jobs\MessagePush;
use App\Models\HomeUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Home\Common\BaseController;

class WeiBoController extends BaseController
{
    /**
     * 初始化接口
     */
    public function init()
    {
        return Socialite::with('weibo')->redirect();
    }

    /**
     * 获取用户信息
     */
    public function callback() {
        //获取用户信息
        $oauthUser = Socialite::with('weibo')->user();

        $userInfo['nickname'] = $oauthUser->nickname ?? '';
        $userInfo['access_token'] = $oauthUser->token ?? '';
        $userInfo['open_id'] = $oauthUser->id ?? '';
        $userInfo['avatar'] = $oauthUser->avatar ?? '';
        $userInfo['phone'] = $oauthUser->phone ?? '';
        $userInfo['email'] = $oauthUser->email ?? '';
        $userInfo['phone'] = $oauthUser->avatar ?? '';

        //注册用户
        if(!$userId = HomeUsers::createUser($userInfo)) return redirect('/blog?error=注册用户失败');
        $userInfo['id'] = $userId;

        $userInfo = json_encode($userInfo);

        //存储到COOKie当中
        Cookie::queue('userinfo', $userInfo, $minutes = 120, $path = null, $domain = null, $secure = false, $httpOnly = false);


        return redirect('/blog');
    }
}

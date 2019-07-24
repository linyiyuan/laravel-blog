<?php

namespace App\Http\Controllers\Home\Auth;

use App\Jobs\MessagePush;
use App\Models\HomeUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Home\Common\BaseController;

class GithubController extends BaseController
{

    public function init()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        //获取用户信息
        $oauthUser = Socialite::driver('github')->user();

        $userInfo['nickname'] = $oauthUser->nickname;
        $userInfo['access_token'] = $oauthUser->token;
        $userInfo['open_id'] = $oauthUser->id;
        $userInfo['avatar'] = $oauthUser->avatar;
        $userInfo['email'] = $oauthUser->email ?? '';

        //注册用户
        if(!$userId = HomeUsers::createUser($userInfo)) return redirect('/blog?error=注册用户失败');
        $userInfo['id'] = $userId;

        $userInfo = json_encode($userInfo);
        //存储到COOKie当中
        Cookie::queue('userinfo', $userInfo, $minutes = 120, $path = null, $domain = null, $secure = false, $httpOnly = false);




        return redirect('/blog');
    }

}

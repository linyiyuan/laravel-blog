<?php

namespace App\Models;

use App\Jobs\MessagePush;
use Illuminate\Database\Eloquent\Model;

class HomeUsers extends Model
{
    protected $table = 'home_users';

    /**
     * 注册用户
     */
    public static function createUser($userinfo)
    {
        if (empty($userinfo)) return false;

        if ($user = self::findHomeUserByOpenId($userinfo['open_id'])) return $user->id;

        $visitor = new Self;
        $visitor->phone = $userinfo['phone'] ?? '';
        $visitor->nickname =  $userinfo['nickname'] ?? '';
        $visitor->open_id =  $userinfo['open_id'] ?? '';
        $visitor->access_token = $userinfo['access_token'] ?? '';
        $visitor->avatar = $userinfo['avatar'] ?? '';
        $visitor->email = $userinfo['email'] ?? '';
        $visitor->lastlogintime = time();
        $visitor->status = 1;
        $visitor->lastloginip = $_SERVER['REMOTE_ADDR'];

        if ($visitor->save()) {
            //推送一条消息
            MessagePush::dispatch([
                'user_id' =>  $visitor->id,
                'message' => ' ',
                'third_id' =>  $visitor->id,
                'type' => 1
            ]);

            return $visitor->id;
        }

        return false;
    }

    /**
     * @param $openId
     * @return bool|\Illuminate\Database\Eloquent\Builder|Model|null|object
     * 按照openid查找用户
     */
    public static function findHomeUserByOpenId($openId)
    {
        if (!$openId) return false;

        if ($userinfo = static::query()->where('open_id',$openId)->first()) return $userinfo;

    }
}

<?php

namespace App\Http\ViewComposers;

use App\Models\Article;
use App\Models\ArticleTags;
use App\Models\ArticleType;
use App\Models\HomeUsers;
use App\Models\Msg;
use Illuminate\View\View;
/**
 * 后台导航栏共享数据
 */
class BackstageHeader
{

    /**
     * 绑定数据到前台文章详情右侧导航.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $header['msg'] = $this->getMsg();


        $view->with('header', $header);


    }

    /**
     * 获取新消息
     *
     * @param View $view
     * @return void
     */
    public function getMsg()
    {
        //获取新消息
        $msg = Msg::orderBy('created_at','desc')
                  ->where('status',0)
        ->limit(3)
        ->get()
        ->toArray();

        $userIds = array_unique(array_column($msg,'user_id'));

        //获取用户信息
        $userinfo = HomeUsers::select('nickname','avatar','id')
                             ->whereIn('id',$userIds)
                             ->get()
                             ->toArray();
        $userinfo = array_combine(array_column($userinfo,'id'),$userinfo);

        $count = Msg::where('status',0)->count();//获取新消息数量

        $msgData = [];
        foreach ($msg as $k)
        {
            $msgData[$k['id']]['id'] = $k['id'];
            $msgData[$k['id']]['message'] = $k['message'];
            $msgData[$k['id']]['created_at'] = $k['created_at'];
            $msgData[$k['id']]['nickname'] = $userinfo[$k['user_id']]['nickname'];
            $msgData[$k['id']]['avatar'] = $userinfo[$k['user_id']]['avatar'];
        }

        return [
            'msgData' => $msgData,
            'count' => $count
        ];
    }

}
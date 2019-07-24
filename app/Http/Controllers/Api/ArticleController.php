<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Common\BaseController;
use App\Jobs\MessagePush;
use App\Models\Article;
use App\Models\Praise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ArticleController extends BaseController
{
    /**
     * @var hash
     * Redis中赞美Hash表
     */
    private $article_praise_redis_hkey = 'Article_Praise';


    /**
     * 文章赞操作
     */
    public function praise(Request $request)
    {
        if (!$request->user_id && !$request->article_id) return $this->errorReturn(500,'参数错误');

        $user_id = $request->user_id;
        $article_id = $request->article_id;

        if (Praise::where([['user_id',$user_id],['article_id',$article_id]])->first()) return $this->errorReturn(500,'您已经点赞过了');

        $praise = new Praise();
        $praise->user_id = $user_id;
        $praise->article_id = $article_id;

        //开启事务
        DB::beginTransaction();
        if (!$praise->save()) return $this->errorReturn('500','点赞失败，请重试');

        if(!Article::where('id',$article_id)->increment('praise')) $this->errorReturn('500','点赞失败，请重试');

        MessagePush::dispatch([
            'message' => '',
            'third_id' => $article_id,
            'user_id' => $user_id,
            'type' => 4
        ]);

        if (Redis::hget($this->article_praise_redis_hkey,$article_id)){
           Redis::hset($this->article_praise_redis_hkey,$article_id,1);
        }else{
            Redis::hincrby('Article_Praise',$article_id,1);
        }
        DB::commit();

       return $this->successReturn('200',Redis::hget($this->article_praise_redis_hkey,$article_id));

    }
}

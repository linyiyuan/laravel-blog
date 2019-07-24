<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\Carousel;
use Illuminate\Support\Facades\Redis;

class ArticleObserver
{
    protected  $redis_article = 'Article';//存储文章内容的redis键

    protected  $redis_article_list = 'Article_List';//存储文章列表的redis键

    protected  $hash_article_key = 'Article_id_';//存储文章内容的hash键

    protected  $hash_article_home_list = 'Article_Home_List';//存储首页文章列表页的hash键

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-28
     * @监听文章增加事件
     */
    public function created(Article $article)
    {
       Redis::del($this->redis_article_list);//删除redis文章列表
    }


    /**
     * 监听文章删除事件。
     *
     * @param  Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
       $article_id = $article->id;//获取文章id

       Redis::hdel($this->redis_article,$this->hash_article_key.$article_id);//删除redis中文章的某一篇文章

       Redis::del($this->redis_article_list);//删除redis文章列表

    }

    /**
     * 监听文章编辑事件。
     *
     * @param  Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
       $article_id = $article->id;

       Redis::hdel($this->redis_article,$this->hash_article_key.$article_id);//删除redis中文章的某一篇文章

       Redis::del($this->redis_article_list);//删除redis文章列表
    }

}
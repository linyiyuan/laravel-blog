<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class CacheController extends Controller
{
    protected static $redis_article = 'Article';//存储文章内容的redis键

    protected static $redis_article_list = 'Article_List';//存储文章列表的redis键

	protected static $hash_article_key = 'Article_id_';//存储文章内容的hash键

    protected static $hash_article_home_list = 'Article_Home_List';//存储首页文章列表页的hash键

    protected static $hash_article_list = 'Article_List_';//存储文章列表页的hash键


	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-08-21
	 * @copyright 添加文章缓存
     * @param     [Object]      $article[文章模型]
	 */
    public static function articleCache($article)
    {
    	if (empty($article)) {
    		return false;
    	}

    	$article_id = $article->id;//得到文章id

    	$article = json_encode($article);//转换json

   		Redis::hset(self::$redis_article,self::$hash_article_key.$article_id,$article);
    }   

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-23
     * @copyright 添加博客首页文章列表
     * @param     [object]      $list [文章列表查询结果]
     */
    public static function homeArticleList($list)
    {
        if (empty($list)) {
            return false;
        }

        $list = json_encode($list);//转换json

        Redis::hset(self::$redis_article_list,self::$hash_article_home_list,$list);
    }

    public static function ArticleList($list,$page)
    {   
        if (empty($list)) {
            return false;
        }

        $list = json_encode($list);//转换json

        Redis::hset(self::$redis_article_list,self::$hash_article_list.$page,$list);
    }
}

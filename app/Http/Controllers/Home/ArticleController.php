<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Carousel;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ArticleTags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Home\Common\BaseController;
use App\Http\Controllers\Admin\Common\CacheController;

class ArticleController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-30
	 * @在前台显示文章详情
	 * @param     [integer]      $id [文章id]
	 */
    public function index($id)
    {   
        //判断缓存是否存在该数据，如果存在直接返回视图层
        if ($article=Redis::hget('Article','Article_id_'.$id)) {
            $article = json_decode($article);
            
            //转换标签为数组
            $article->tags = $this->toArray($article->tags);
        }elseif ($article=Article::where('is_show',1)->find($id)) {
            //处理标签
            $tags = [];
            foreach ($article->tags as $key) {
                $tags[] = ['id' => $key->id,'tag_name' => $key->tag_name];
            }
            $article->tags = $tags;
            //加入缓存
            CacheController::articleCache($article);
        }else{
             return view('home.error.404');
        }

        $articleList = $this->getArticleList($id);//获取文章列表

        $articleComment = $this->getArticleListComment($id);//获取文章评论列表

        $articheWatch = $this->getArticleWatch($id);//获取文章的观看数

        $articlePraise = $this->getArticlePraise($id);//获取文章赞数

        return view('home.article',compact('article','articleList','articleComment','articheWatch','articlePraise'));
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-30
     * @获取文章的前后两篇文章，以及相关标签的文章
     */
    protected function getArticleList($id)
    {
    	if (!intval($id)) {
    		return [];
    	}

    	$articleList = [];
    	//获取文章的上一篇文章以及下一篇文章
    	$articleList['preArticle'] = Article::select('id','title')
                                            ->where('time','<',time())
                                            ->where('is_show','1')
                                            ->where('id','<',$id)
                                            ->first();
                                            
    	$articleList['nextArticle'] = Article::select('id','title')
                                             ->where('time','<',time())
                                             ->where('is_show','1')
                                             ->where('id','>',$id)
                                             ->first();
    	
    	$article = Article::select('id')
    					  ->where('id',$id)
    					  ->first();

    	//获取该文章的所有标签
    	$tags = array_column($this->toArray($article->tags), 'id');

    	//获取与该文章类似相关的文章id
    	$articleRelevantId = DB::table('article_tags')->select('article_id')
    								  ->whereIn('tag_id',$tags)
    								  ->get();

    	$articleRelevantId = array_column($this->toArray($articleRelevantId),'article_id');
    	//去重
    	$articleRelevantId = array_unique($articleRelevantId);


    	$articleList['articleRelevant'] = Article::select('id','title')
                                                  ->where('time','<',time())
                                                  ->where('is_show','1')
				    							  ->orderBy('created_at','desc')
				    							  ->whereIn('id',$articleRelevantId)
				    							  ->get();

    	return $articleList;
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-14
     * @copyright 获取文章评论
     */
    public function getArticleListComment($id)
    {
        if (!intval($id)) {
            return [];
        }

        $comment = Comment::from('comment as c')
                            ->select('c.type','c.comment','c.created_at','h.nickname','h.avatar','c.id','c.user_id')
                            ->join('home_users as h','c.user_id','=','h.id')
                            ->orderBy('c.created_at','asc')
                            ->where('article_id',$id)
                            ->where('c.deleted',0)
                            ->get();

        return $comment;
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-29
     * @获取文章观看数以及文章观看数递增
     */
    public function getArticleWatch($id)
    {
        if (!intval($id)) {
            return 0;
        }
        Redis::Hincrby('Article_Watch','Article_'.$id,1);//文章观看数自增1

        $watch = Redis::Hget('Article_Watch','Article_'.$id);//获取文章观看数

        return $watch;

    }

    public function getArticlePraise($id)
    {
        if (!intval($id)) {
            return 0;
        }

        $watch = Redis::Hget('Article_Praise',$id);//获取文章观看数

        return $watch;
    }

}

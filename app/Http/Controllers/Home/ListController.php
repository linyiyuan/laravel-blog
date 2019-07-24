<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Carousel;
use App\Models\Article;
use App\Models\ArticleTags;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Home\Common\BaseController;
use App\Http\Controllers\Admin\Common\CacheController;


class ListController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-31
	 * @文章列表页
	 */
    public function index(Request $request)
    {
    	$nowPage = $request->page?$request->page:1;//获取当前页数
    	$pageSize = 10;
    	$offset = ($nowPage - 1) * $pageSize;

    	$page = [];
    	$page['pageSize'] = $pageSize;//获取每页显示条目数

    	$page['total'] = Article::where('is_show','1')
                              ->where('time','<',time())
                              ->count();//获取总数

    	$page['totalPage'] = ceil(intval($page['total']) / intval($pageSize));//获取总页数

    	$page['nowPage'] = $nowPage;

      if (!$articleList=Redis::Hget('Article_List','Article_List_'.$nowPage)) {
          $articleList = Article::where('is_show','1')
                  ->where('time','<',time())
                  ->orderBy('is_up','desc')
                  ->orderBy('created_at','desc')
                  ->offset($offset)
                  ->limit($pageSize)
                  ->get();

          foreach ($articleList as $key => $value) {
                  $tags = [];
                  foreach ($value->tags as $k) {
                      $tags[] = ['id' => $k->id,'tag_name' => $k->tag_name];
                  }
                  $articleList[$key]->tags = $value->tags;            
          }

          CacheController::ArticleList($articleList,$nowPage);
      }

      $article = json_decode($articleList);

    	return view('home.list',compact('article','page'));
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-31
     * @文章标签筛选列表页
     */
    public function tags($id,Request $request)
    {
        $nowPage = $request->page?$request->page:1;//获取当前页数
        $pageSize = 9;
        $offset = ($nowPage - 1) * $pageSize;

        $page = [];
        $page['pageSize'] = $pageSize;//获取每页显示条目数

        $page['total'] = DB::table('article_tags')->where('tag_id',$id)->count();//获取总数

        $page['totalPage'] = ceil(intval($page['total']) / intval($pageSize));//获取总页数

        $page['nowPage'] = $nowPage;


        $article_ids = DB::table('article_tags')
                         ->select('article_id')
                         ->where('tag_id',$id)
                         ->offset($offset)
                         ->limit($pageSize)
                         ->get();
        $article_ids = array_column($this->toArray($article_ids),'article_id');

        $article = Article::where('is_show','1')
                          ->where('time','<',time())
                          ->whereIn('id',$article_ids)
                          ->orderBy('created_at','desc')
                          ->get();

        return view('home.list',compact('article','page'));
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-31
     * @文章标签筛选列表页
     */
    public function type($id,Request $request)
    {
      if (!intval($id)) {
            return view('home.error.404');
      }

      $articleType = ArticleType::select('is_show')->where('id',$id)->first();
      //判断是否有该分类
      if (!isset($articleType)) {
        return view('home.error.404');
      }
      //判断分类是否在首页有显示
      if ($articleType->is_show === 0) {
        return view('home.error.404');
      }
      
      $nowPage = $request->page?$request->page:1;//获取当前页数

      $pageSize = 9;
      $offset = ($nowPage - 1) * $pageSize;

      $page = [];
      $page['pageSize'] = $pageSize;//获取每页显示条目数

      $page['total'] = Article::where('type',$id)->count();//获取总数

      $page['totalPage'] = ceil(intval($page['total']) / intval($pageSize));//获取总页数

      $page['nowPage'] = $nowPage;

      $article = Article::where('is_show','1')
                ->where('time','<',time())
                ->where('type',$id)
                ->orderBy('is_up','desc')
                ->orderBy('created_at','desc')
                ->offset($offset)
                ->limit($pageSize)
                ->get();

      return view('home.list',compact('article','page'));

    }
}

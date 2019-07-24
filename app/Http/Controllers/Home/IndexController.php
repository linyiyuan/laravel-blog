<?php

namespace App\Http\Controllers\Home;

use App\Models\Links;
use App\Models\Carousel;
use App\Models\Article;
use App\Models\ArticleTags;
use Illuminate\Http\Request;
use App\Events\ArticleCache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Home\Common\BaseController;
use App\Http\Controllers\Admin\Common\CacheController;

class IndexController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-07-27
	 * @用来展示前台入口页面
	 */
  	public function index(Request $request)
  	{
  		//获取首页轮播图
  		$home['carousel'] = $this->getCarousel();

  		//获取最新的八篇在首页显示
  		$home['article'] = $this->getArticle();

  		//获取全部的标签云
  		$home['articleTags'] = $this->getArticleTags();

  		//获取博主推荐的文章
  		$home['recommendArticle'] = $this->getRecommendArticle();

        //获取点击排行的文章
        $home['HotsArticle'] = $this->getHotsArticle();

        //获取友情链接
        $home['links'] = $this->getLinks();

        return view('home.index',compact('home'));
  	}


  	/**
  	 * @Author    linyiyuan
  	 * @DateTime  2018-07-27
  	 * @获取首页轮播图
  	 */
  	protected function getCarousel()
  	{
  		$carousel = Carousel::where('is_show','1')
    	  				->limit(5)
    	  				->orderBy('sort','asc')
    	  				->get();

	  	return $carousel;
  	}

  	/**
  	 * @Author    linyiyuan
  	 * @DateTime  2018-07-27
  	 * @获取首页最新的8篇文章
  	 */
  	protected function getArticle()
  	{
      if (!$articleList=Redis::Hget('Article_List','Article_Home_List')) {
          $articleList = Article::where('is_show','1')
                                ->where('time','<',time())
                                ->orderBy('is_up','desc')
                                ->orderBy('created_at','desc')
                                ->limit(8)
                                ->get();

          foreach ($articleList as $key => $value) {
              $tags = [];
              foreach ($value->tags as $k) {
                  $tags[] = ['id' => $k->id,'tag_name' => $k->tag_name];
              }
              $articleList[$key]->tags = $value->tags;            
          }
          CacheController::homeArticleList($articleList);//加入缓存
      }

  		$articleList = json_decode($articleList);

		  return $articleList;
  	}

  	/**
  	 * @Author    linyiyuan
  	 * @DateTime  2018-07-27
  	 * @获取所有的文章标签云
  	 */
  	protected function getArticleTags()
  	{
  		$articleTags = ArticleTags::get();

  		return $articleTags;
  	}

  	/**
  	 * @Author    linyiyuan
  	 * @DateTime  2018-07-27
  	 * @获取博主推荐的文章
  	 */
  	protected function getRecommendArticle()
  	{
  		$recommendArticle = Article::where([['is_show','1'],['is_recommend','1']])
                    						  ->where('time','<',time())
                  			  			  ->orderBy('created_at','desc')
                  			  			  ->limit(2)
                  			  			  ->get();

	 	  return $recommendArticle;
  	}

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-31
     * @获取点击排行前六个文章
     */
    protected function getHotsArticle()
    {
      $hotsArticle = Article::select('id','title','cover','desc')
                             ->where([['is_show','1']])
                             ->where('time','<',time())
                             ->orderBy('click','desc')
                             ->orderBy('created_at','desc')
                             ->limit(6)
                             ->get();

      return $hotsArticle;
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-30
     * @获取友情链接
     */
    protected function getLinks()
    {
        $links = Links::select('url','title')
                      ->orderBy('created_at','desc')
                      ->get();
        return $links;
    }
}

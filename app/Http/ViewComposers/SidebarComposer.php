<?php

namespace App\Http\ViewComposers;

use App\Models\Article;
use App\Models\ArticleTags;
use App\Models\ArticleType;
use Illuminate\View\View;
/**
 * 后台导航栏共享数据
 */
class SidebarComposer
{

    /**
    * 绑定数据到前台文章详情右侧导航.
    *
    * @param View $view
    * @return void
    */
    public function compose(View $view)
    {
        $sidebar = [];

        //获取所有文章标签
        $sidebar['articleTags'] = $this->getArticleTags();

        //获取文章点击排行
        $sidebar['articleClickDescList'] = $this->getArticleClick();

        //获取所有文章分类信息
        $sidebar['articleType'] = $this->getAritcleType();

        $view->with('sidebar', $sidebar);

       
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
     * @获取文章点击排行
     */
    protected function getArticleClick()
    {
      $articleClickDescList = Article::select('cover','id','desc','title')
                                     ->where('is_show',1)
                                     ->where('time','<',time())
                                     ->orderBy('click','desc')
                                     ->orderBy('created_at','desc')
                                     ->limit(8)
                                     ->get();
      return $articleClickDescList;
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-01
     * 获取所有文章分类
     */
    protected function getAritcleType()
    {
        //获取所有分类
        $articleType = ArticleType::select('id','parent_id','type_name')
                                  ->where('is_show','1')
                                  ->orderBy('sort','desc')
                                  ->get();
        $type = [];

        //对所有顶级分类进行处理排序
        foreach ($articleType as $key) {
            if ($key->parent_id == 0) {
                $type[$key->id]['parent_id'] = $key->parent_id;
                $type[$key->id]['type_name'] = $key->type_name;
            }
        }
        //分类排序
        ksort($type);

        // 递归子分类
        foreach ($articleType as $key) {
           if ($key->parent_id != 0 && array_key_exists($key->parent_id, $type)) {
               $type[$key->parent_id]['list'][$key->id]['id'] = $key->id;
               $type[$key->parent_id]['list'][$key->id]['type_name'] = $key->type_name;
            } 
        }
        return $type;
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Models\OperationLog;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 * 后台首页控制器
 */
class IndexController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取最新的操作日志
        $operationLog = OperationLog::select('*')
                                    ->orderBy('created_at','desc')
                                    ->limit(6)
                                    ->get();

        //获取最新的文章     
        $article = Article::select('title','is_show','id')
                          ->orderBy('created_at','desc')
                          ->limit(9)
                          ->get();

        //得到所有数据统计数量
        $dataStatistics = $this->getdataStatistics();

        return view('admin.index.index',compact('operationLog','article','dataStatistics'));
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-18
     * @获取首页数据统计
     * @return    [array]      [数据统计]
     */
    private function getdataStatistics()
    {
        $data = [];
        //获取文章总数量
        $data['articleCount'] = Article::count();
        //获取用户总数量
        $data['visitorCount'] = Visitor::count();
        //获取评论总数
        $data['commentCount'] = Comment::count();


        return $data;
    }
}

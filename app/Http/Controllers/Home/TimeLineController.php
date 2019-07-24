<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Common\BaseController;

class TimeLineController extends BaseController
{
   /**
    * @Author    linyiyuan
    * @DateTime  2018-08-10
    * @显示时间轴的页面
    */
   public function index()
   {
   		$where = [
   			['is_show','1'],
   			['time','<',time()]
   		];

   		$article = Article::select('created_at','id','title')
   					   ->where($where)
   					   ->orderBy('created_at','desc')
   					   ->groupBy('created_at')
   					   ->get();

   		$date_id = array_column($this->toArray($article), 'id','created_at');
   		$title_id = array_column($this->toArray($article), 'title','id');

   		$list = [];
   		// dd($date_id);

   		foreach ($date_id as $key => $value) {
   			$list[date('Y-m',strtotime($key))][$key]['id'] = $value;
   			$list[date('Y-m',strtotime($key))][$key]['title'] = $title_id[$value];
   		}
   		// dd($list);
   		return view('home.timeline',compact('list'));
   }
}

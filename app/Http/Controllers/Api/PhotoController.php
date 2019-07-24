<?php

namespace App\Http\Controllers\Api;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Common\BaseController;

class PhotoController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-06-28
	 * @获取到图片的数据
	 * @param     $cur_page 		   当前页
	 * @param     $page_size 		   每页显示条数
	 * @return    [json]               [查询到的数据]
	 */
    public function getDetail(Request $request)
    {
      $where = [];
    	if (empty($cur_page=$request->cur_page) || empty($page_size=$request->page_size)) {
    		return $this->errorReturn('500','非法参数');
    	}

      if ($photo_album_id=$request->photo_album_id) {
          $where[] = ['photo_album',$photo_album_id];
      }
    	$offset = ($cur_page - 1)*$page_size;

    	$photo = Photo::select('id','img')
                    ->where($where)
                    ->limit($page_size)
                    ->offset($offset)
                    ->get();

        return $this->successReturn(200,$photo);
    }
}

<?php

namespace App\Http\Controllers\Home;

use Pinyin;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Common\BaseController;

class PhotoAlbumController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-08-08
	 * @获取相册列表P
	 */
   	public function index()
   	{
   		$list = PhotoAlbum::where('photo_permission','0')
                           ->orderBy('created_at','desc')
      						   ->get();

   		//将相册转换并且分组
   		$list = array_chunk($this->toArray($list), 2);

   		return view('home.photo_album',compact('list'));
   	}

   	/**
   	 * @Author    linyiyuan
   	 * @DateTime  2018-08-09
   	 * @照片列表页
   	 * @param     [string]      $type    [相册]
   	 */
   	public function photo($type,Request $request)
   	{
   		if (strlen($type) < 0) {
   			return $this->getNotPage();
   		}

   		//获取所有相册集
   		$photo_album = PhotoAlbum::where('photo_permission','0')
                                  ->select('id','name')
   								       ->get();

   		$photo_album = array_column($this->toArray($photo_album), 'name','id');
   		$photo_album = array_map(function($val){
   			return app('pinyin')->permalink($val);
   		}, $photo_album);

   		//判断是否存在该相册集
   		if (!in_array($type, $photo_album)) {
   			return $this->getNotPage();
   		}
   		$photo_album_id = array_search($type, $photo_album);

   		$photo = Photo::select('id','img')
   					  ->where('photo_album',$photo_album_id)
                      ->limit(12)
                      ->offset(0)
                      ->get();

   		return view('home.photo',compact('photo','photo_album_id'));
   	}
}

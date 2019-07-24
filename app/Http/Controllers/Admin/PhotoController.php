<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class PhotoController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $page_size = 12;//每页显示条目数

        //判断是查询某个相册的图片
        if (intval($photo_album_id=$request->photo_album_id)) {
            if ($photo_album=PhotoAlbum::find($photo_album_id)) {
                $where[] = ['photo_album',$photo_album_id];  
            }
        }

        $photo = Photo::select('id','img')
                      ->where($where)
                      ->limit($page_size)
                      ->offset(0)
                      ->get();



        return view('admin.photo.list',compact('photo'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.photo.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //判断是否有无相册选择
        if ($photo_album_id=$request->photo_album_id) {
            $file_name = $request->id;

            $data = [
                'photo_album' => $photo_album_id
            ];
            $bool = Photo::where('photo_album',0)->update($data); 

            return $bool; 
        }
        $data = Input::all();

        //得到文件
        $img = $data['file'];

        //文件允许的类型
        $imageType = ['image/jpeg','image/jpg','image/png'];

        //文件源名字
        $originalName = $img->getClientOriginalName();

        //文件后缀
        $extension = $img->getClientOriginalExtension();

        //文件绝对路径
        $realPath  = $img->getRealPath();

        $contentPath = '/photo/pic'.'/'.$originalName;//拼接得到图片的名称
            //上传图片到七牛云
        $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));

        $photo = new Photo();

        $photo->img = config('app.qiniu_cdn').$contentPath;
        $photo->photo_album = 0;
        $photo->save();
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = '')
    {
        if (empty($id)) {
            return false;
        }

        Photo::where('img','like','%'.$id.'%')->delete();
    }
}

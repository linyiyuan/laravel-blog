<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use App\Models\PhotoAlbumType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 * 相册控制器
 */
class PhotoAlbumController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $search = [];

        //筛选相册名
        if (strlen($name=$request->name) > 0) {
           $where[] = ['name','like','%'.$name.'%'];
           $search['name'] = $name; 
        }

        //筛选相册分类
        if (strlen($type_name=$request->type_name) > 0 && $type_name != -1) {
           $where[] = ['type',$type_name];
           $search['type_name'] = $type_name; 
        }


        //获取所有相册分类
        $photoAlbumType = PhotoAlbumType::select('type_name','id')
                                        ->get();
        $photoAlbumType = json_decode(json_encode($photoAlbumType),true);
        $photoAlbumType = array_column($photoAlbumType, 'type_name','id');

        //获取所有相册
        $photoAlbum = PhotoAlbum::select('*')
                                  ->orderBy('created_at','desc')
                                  ->where($where)
                                  ->paginate(9);

        //获取相册分组数据
        $photoNum = Photo::select(DB::raw('count(*) as count, photo_album'))
                         ->groupBY('photo_album')
                         ->get();
        $photoNum = array_column($this->toArray($photoNum), 'count','photo_album');

        return view('admin.photo_album.list',compact('photoAlbum','search','photoAlbumType','photoNum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $photoAlbum = new PhotoAlbum();

        //获取到相册分类
        $photoAlbumType = PhotoAlbumType::select('id','type_name')->get();

        return view('admin.photo_album.edit',compact('photoAlbum','photoAlbumType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'type' => 'required',
            'photo_permission' => 'required',
            'name' => 'required',
        ]);


        $photoAlbum = new PhotoAlbum();

        $photoAlbum->name = isset($request->name)?$request->name:'';
        $photoAlbum->type = isset($request->type)?$request->type:'';
        $photoAlbum->photo_permission = isset($request->photo_permission)?$request->photo_permission:0;
        $photoAlbum->desc = isset($request->desc)?$request->desc:0;
        $photoAlbum->question = isset($request->question)?$request->question:'';
        $photoAlbum->answer = isset($request->answer)?$request->answer:'';
        $photoAlbum->author = Auth::user()->name;

        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/article')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $photoAlbum->cover = $path;
        }

        if (!$photoAlbum->save()) {
            return $this->error('添加相册失败');
        }

        return $this->success('添加相册成功');
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
        if(!intval($id)){
            return $this->error('非法参数');
        }

        if (empty($photoAlbum=PhotoAlbum::find($id))) {
             return $this->error('获取数据失败');
        }

        $photoAlbumType = PhotoAlbumType::select('id','type_name')->get();

        return view('admin.photo_album.edit',compact('photoAlbum','photoAlbumType'));
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
        if(!intval($id)){
            return $this->error('非法参数');
        }

        if (empty($photoAlbum=PhotoAlbum::find($id))) {
             return $this->error('获取数据失败');
        }

        $this->validate($request,[
            'type' => 'required',
            'photo_permission' => 'required',
            'name' => 'required',
        ]);

        $photoAlbum->name = isset($request->name)?$request->name:'';
        $photoAlbum->type = isset($request->type)?$request->type:'';
        $photoAlbum->photo_permission = isset($request->photo_permission)?$request->photo_permission:0;
        $photoAlbum->desc = isset($request->desc)?$request->desc:0;
        $photoAlbum->question = isset($request->question)?$request->question:'';
        $photoAlbum->answer = isset($request->answer)?$request->answer:'';
        $photoAlbum->author = Auth::user()->name;

        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/article')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $photoAlbum->cover = $path;
        }

        if (!$photoAlbum->save()) {
            return $this->error('修改相册失败');
        }

        return $this->success('修改相册成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!intval($id)) {
             return $this->ajaxResponse('500','非法参数');
        }

        if (!$res=PhotoAlbum::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        //删除相册下所有图片
        Photo::where('photo_album',$id)->delete();
        return $this->ajaxResponse('200','删除成功');
    }
}

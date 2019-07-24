<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PhotoAlbumType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class PhotoAlbumTypeController extends CommonController
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

        if (strlen($typeName=$request->type_name) > 0) {
           $where[] = ['type_name','like','%'.$typeName.'%'];
           $search['type_name'] = $typeName; 
        }

        $photoAlbumType = PhotoAlbumType::select('*')
                                          ->orderBy('sort','desc')
                                          ->where($where)
                                          ->paginate(10);

        return view('admin.photo_album_type.list',compact('photoAlbumType','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $photoAlbumType = new PhotoAlbumType();

        return view('admin.photo_album_type.edit',compact('photoAlbumType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_name' => 'required|unique:photo_album_type|max:255',
            'sort' => 'required|integer'
        ]);

        $photoAlbumType = new PhotoAlbumType();

        $photoAlbumType->type_name = isset($request->type_name)?$request->type_name:'';
        $photoAlbumType->sort = isset($request->sort)?$request->sort:'0';
        $photoAlbumType->desc = isset($request->desc)?$request->desc:'';
        $photoAlbumType->is_show = 0;

        if (!$photoAlbumType->save()) {
            return $this->error('添加相册分类失败');
        }

        return $this->success('添加相册分类成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        if (strlen($is_show=$request->is_show) < 0) {
            return $this->error('获取当前状态失败');
        }

        if ($is_show == 0) {
            if(!PhotoAlbumType::where('id',$id)->update(['is_show' => 1])){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }elseif ($is_show == 1) {
            if(!PhotoAlbumType::where('id',$id)->update(['is_show' => 0])){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }
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

        if (empty($photoAlbumType=PhotoAlbumType::find($id))) {
             return $this->error('获取数据失败');
        }

        return view('admin.photo_album_type.edit',compact('photoAlbumType'));
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

        if (empty($photoAlbumType=PhotoAlbumType::find($id))) {
             return $this->error('获取数据失败');
        }

        $this->validate($request, [
            'type_name' => 'required',
            'sort' => 'required|integer'
        ]);

        $photoAlbumType->type_name = isset($request->type_name)?$request->type_name:'';
        $photoAlbumType->sort = isset($request->sort)?$request->sort:'0';
        $photoAlbumType->desc = isset($request->desc)?$request->desc:'';

        if (!$photoAlbumType->save()) {
            return $this->error('修改失败');    
        }

        return $this->success('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

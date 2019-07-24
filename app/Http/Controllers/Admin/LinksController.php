<?php

namespace App\Http\Controllers\Admin;

use App\Models\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class LinksController extends CommonController
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

        if (strlen($title=$request->title) > 0) {
           $where[] = ['title','like','%'.$title.'%'];
           $search['title'] = $title;
        }

        $links = Links::where($where)
                      ->paginate(10);

        return view('admin.links.list',compact('links','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $links = new Links();

        return view('admin.links.edit',compact('links'));
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
            'title' => 'required',
            'url' => 'required',
        ]);

        $links = new Links();

        $links->title = $request->title?$request->title:'';
        $links->url = $request->url?$request->url:'';
        $links->email = $request->email?$request->email:'';
        $links->is_show = $request->is_show?$request->is_show:'0';

        if (!$links->save()) {
            return $this->error('添加一条友情链接失败');
        }

        return $this->success('添加一条友情链接成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        if (strlen($is_show=$request->is_show) < 0) {
            return $this->error('获取当前状态失败');
        }

        if ($is_show == 0) {
            if(!Links::where('id',$id)->update(['is_show' => 1])){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }elseif ($is_show == 1) {
            if(!Links::where('id',$id)->update(['is_show' => 0])){
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

        if (empty($links=Links::find($id))) {
             return $this->error('获取数据失败');
        }


        return view('admin.links.edit',compact('links'));
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
        $this->validate($request, [
            'title' => 'required',
            'url' => 'required',
        ]);

        if(!intval($id)){
            return $this->error('非法参数');
        }

        if (empty($links=Links::find($id))) {
             return $this->error('获取数据失败');
        }

        $links->title = $request->title?$request->title:'';
        $links->url = $request->url?$request->url:'';
        $links->email = $request->email?$request->email:'';

        if (!$links->save()) {
            return $this->error('修改友情链接失败');
        }

        return $this->success('修改友情链接成功');
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

        if (!$res=Links::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }
}

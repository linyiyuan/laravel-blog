<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ArticleType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 * 文章分类控制器
 */
class ArticleTypeController extends CommonController
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

        //筛选分类名
        if (strlen($typeName=$request->type_name) > 0) {
           $where[] = ['type_name','like','%'.$typeName.'%'];
           $search['type_name'] = $typeName; 
        }

        $articleType = ArticleType::select('*')
                                  ->orderBy('sort','desc')
                                  ->where($where)
                                  ->paginate(10);
        $parentType = $this->getParentType();                         
        return view('admin.type.list',compact('articleType','search','parentType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articleType = new ArticleType();

        $parentType = $this->getParentType();

        return view('admin.type.edit',compact('articleType','parentType'));
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
            'type_name' => 'required|unique:article_type|max:255',
            'sort' => 'required|integer'
        ]);

        $articleType = new ArticleType();

        $articleType->type_name = isset($request->type_name)?$request->type_name:'';
        $articleType->sort = isset($request->sort)?$request->sort:'0';
        $articleType->desc = isset($request->desc)?$request->desc:'';
        $articleType->parent_id = isset($request->parent_id)?$request->parent_id:'0';
        $articleType->is_show = 0;

        if (!$articleType->save()) {
            return $this->error('添加文章分类失败');
        }

        return $this->success('添加文章分类成功');
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
            if(!ArticleType::where('id',$id)->update(['is_show' => 1])){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }elseif ($is_show == 1) {
            if(!ArticleType::where('id',$id)->update(['is_show' => 0])){
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

        if (empty($articleType=ArticleType::find($id))) {
             return $this->error('获取数据失败');
        }

        $parentType = $this->getParentType();
        return view('admin.type.edit',compact('parentType','articleType'));
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

        if (empty($articleType=ArticleType::find($id))) {
             return $this->error('获取数据失败');
        }

        $this->validate($request, [
            'type_name' => 'required',
            'sort' => 'required|integer'
        ]);

        $articleType->type_name = isset($request->type_name)?$request->type_name:'';
        $articleType->sort = isset($request->sort)?$request->sort:'0';
        $articleType->desc = isset($request->desc)?$request->desc:'';
        $articleType->parent_id = isset($request->parent_id)?$request->parent_id:'0';

        if (!$articleType->save()) {
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

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-01
     * @获取所有顶级分类信息
     */
    private function getParentType()
    {
        //获取所有的父级分类
        $parentType = ArticleType::select('type_name','id')
                                  ->where('parent_id',0)
                                  ->get();

        $parentType = array_column($this->toArray($parentType),'type_name','id');

        return $parentType;
    }
}

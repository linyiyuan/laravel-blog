<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ArticleTags;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 *文章标签控制器
 */
class ArticleTagsController extends CommonController
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

        //筛选文章标签名
        if (strlen($tag_name=$request->tag_name) > 0) {
           $where[] = ['tag_name','like','%'.$tag_name.'%'];
           $search['tag_name'] = $tag_name; 
        }

        $articleTags = ArticleTags::select('*')
                                  ->orderBy('created_at','desc')
                                  ->where($where)
                                  ->paginate(10);

        return view('admin.tags.list',compact('articleTags','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articleTags = new ArticleTags();

        return view('admin.tags.edit',compact('articleTags'));
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
            'tag_name' => 'required|unique:tags|max:255',
        ]);

        $articleTags = new ArticleTags();

        $articleTags->tag_name = isset($request->tag_name)?$request->tag_name:'';
        $articleTags->tag_desc = isset($request->tag_desc)?$request->tag_desc:'';

        if (!$articleTags->save()) {
            return $this->error('添加文章标签失败');
        }

        return $this->success('添加文章标签成功');

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
    public function destroy($id)
    {
         if (!intval($id)) {
             return $this->ajaxResponse('500','非法参数');
        }

        if (!$res=ArticleTags::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }
}

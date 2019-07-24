<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\Article;
use App\Models\HomeUsers;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class CommentController extends CommonController
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
        if (strlen($comment=$request->comment) > 0) {
            $where[] = ['comment','like','%'.$comment.'%'];
            $search['comment'] = $comment;
        }

        if ($request->s == 'admin/comment_manage/dustbin') {
            $where[] = ['deleted',1];
            $search['deleted'] = 1;
        }else{
            $where[] = ['deleted',0];
            $search['deleted'] = 0;
        }
        //获取所有评论
        $comment = Comment::orderBy('created_at','desc')
                          ->where($where)
                          ->paginate(15);

        //获取所有用户
        $visitor = HomeUsers::select('id','nickname')
                          ->get()
                          ->toArray();
        $visitor = array_column($visitor, 'nickname','id');


        return view('admin.comment.list',compact('comment','visitor','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        if (is_null($comment=Comment::find($id))) {
            return $this->error('获取数据失败');
        }

        if ($comment->deleted == 0) {
            $comment->deleted = 1;
        }else{
            $comment->deleted = 0;
        }

        if (!$comment->save()) {
            return $this->error('移入垃圾箱失败');
        }

        return $this->success('移入垃圾箱成功');

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

        if (!$res=Comment::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }
}

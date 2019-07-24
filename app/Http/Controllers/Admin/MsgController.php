<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessagePush;
use App\Events\PublicMessageEvent;
use App\Models\Msg;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class MsgController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $msg = Msg::orderBy('created_at', 'desc')
            ->paginate(15);

        $msgIds = array_column($msg->toArray()['data'], 'id');

        //标记已读信息
        Msg::whereIn('id',$msgIds)->update(['status' => 1]);

        return view('admin.msg.list', compact('msg'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $ids)
    {
        if (empty($ids) || strlen($request->status) < 0) {
            return $this->ajaxResponse('500','非法参数');
        }
        $ids = json_decode($ids,true);


        if (!$res=Msg::whereIn('id',$ids)->update(['status' => $request->status])) {
            return $this->ajaxResponse('500','更新失败');
        }

        return $this->ajaxResponse('200','更新成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        if (empty($ids)) {
            return $this->ajaxResponse('500','非法参数');
        }
        $ids = json_decode($ids,true);


        if (!$res=Msg::whereIn('id',$ids)->delete()) {
            return $this->ajaxResponse('500','删除失败');
        }

        return $this->ajaxResponse('200','删除成功');
    }

}

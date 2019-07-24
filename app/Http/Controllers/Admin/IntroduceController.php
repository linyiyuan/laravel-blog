<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Introduce;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

class IntroduceController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取文章内容
        $content = Introduce::select('introduce')
                            ->first();

        return view('admin.introduce.list',compact('content'));
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
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        if (!$data=Introduce::find($id)) {
            return $this->error('获取数据失败');
        }

        return view('admin.introduce.edit',compact('data'));
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
        if (!intval($id)) {
            return $this->error('非法参数');
        }

        if (!$data=Introduce::find($id)) {
            return $this->error('获取数据失败');
        }

        $this->validate($request, [
            'screen_names' => 'required|max:255',
         ]);

        $data->screen_names = isset($request->screen_names)?$request->screen_names:'';
        $data->profession = isset($request->profession)?$request->profession:'';
        $data->weixi = isset($request->weixi)?$request->weixi:'';
        $data->qq = isset($request->qq)?$request->qq:'';
        $data->email = isset($request->email)?$request->email:'';
        $data->introduce = isset($request->introduce)?$request->introduce:'';

        if (!$data->save()) {
            return $this->error('修改资料失败');
        }

        return $this->success('修改资料成功');

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

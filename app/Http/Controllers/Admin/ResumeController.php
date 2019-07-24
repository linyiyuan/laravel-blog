<?php

namespace App\Http\Controllers\Admin;

use TCPDF;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\OperationLog;
use App\Models\Introduce;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Common\CommonController;


class ResumeController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!is_null(Introduce::find(1))) {
             $filePath = Introduce::find(1)->resume;
        }else{
             return view('admin.resume.list');
        }


        return view('admin.resume.list',compact('filePath'));
        


      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.resume.edit');
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
            'word' => 'required'
        ]);

        if (!$image=$request->file('word')) {
            return $this->error('请选择文件上传');
        }

        if (is_null($introduce = Introduce::find(1))) {
            return $this->error('获取数据失败');
        }

        $imageType = ['docx'];
        // 得到上传文件源文件名
        $originalName = $image->getClientOriginalName();
        // 得到上传文件的后缀
        $ext = $image->getClientOriginalExtension();
        // 得到上传文件的tmp绝对路径
        $realPath = $image->getRealPath();

        if (!in_array($ext,$imageType)) {
            throw new Exception("上传文件类型错误");
        }

        if ($image->getSize() > 30000000) {
            throw new Exception('上传图片尺寸过大');
        }
        $flieName = 'resume'.'.'.$ext;
        
        $contentPath = 'admin/resume'.'/'.$flieName;//拼接得到图片的名称

        //上传图片到七牛云
        $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));

        
        if ($bool) {
            $introduce->resume = env('QINIU_DEFAULT').$contentPath;
            if (!$introduce->save()) {
                return $this->error('添加数据失败');
            }else{
                return $this->success('添加数据成功');
            }
            
        }else{
            return $this->error('上传文件失败');
        }
        

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
        //
    }
}

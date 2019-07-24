<?php

namespace App\Http\Controllers\Admin;

use App\Models\Carousel;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 * 轮播图控制器
 */
class CarouselController extends CommonController
{
    private $carousel;//轮播图对象
    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-17
     * 初始化函数
     */
    public function __construct()
    {
        $this->carousel = new Carousel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $search = [];

        //标题筛选
        if (strlen($title=$request->title) > 0)  {
           $where[] = ['title','like', '%'.$title.'%'];
           $search['title'] = $title;
        }
        //分类筛选
        if ($request->type != -1 && strlen($type=$request->type) > 0 ){
           $where[] = ['type' , $type];
           $search['type'] = $type;
        }
        $carousel = Carousel::select()
                            ->orderBy('created_at','desc')
                            ->where($where)
                            ->paginate(10);

        return view('admin.carousel.list',compact('carousel','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carousel = $this->carousel;

        $article = Article::select('id','title')->get();

        return view('admin.carousel.edit',compact('carousel','article'));
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
            'type' => 'required',
            'third_id' => 'required',
        ]);

        $carousel = $this->carousel;

        $carousel->title = isset($request->title)?$request->title:'';
        $carousel->sub_title = isset($request->sub_title)?$request->sub_title:'';
        $carousel->type = isset($request->type)?$request->type:1;
        $carousel->sort = isset($request->sort)?$request->sort:1;
        $carousel->is_show = isset($request->is_show)?$request->is_show:1;
        $carousel->url = isset($request->url)?$request->url:'';
        $carousel->third_id = isset($request->third_id)?$request->third_id:1;
        
         //处理文件上传
        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/carousel')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $carousel->cover = $path;
        }

        if (!$carousel->save()) {
            return $this->error('添加轮播图失败');
        }
        return $this->success('添加轮播图成功');
        
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
            if(!Carousel::where('id',$id)->update(['is_show' => 1])){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }elseif ($is_show == 1) {
            if(!Carousel::where('id',$id)->update(['is_show' => 0])){
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

        if (empty($carousel=Carousel::find($id))) {
             return $this->error('获取数据失败');
        }

        $article = Article::select('id','title')->get();//获取所有文章

        return view('admin.carousel.edit',compact('carousel','article'));
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

        if (empty($carousel=Carousel::find($id))) {
             return $this->error('获取数据失败');
        }

        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'third_id' => 'required',
        ]);

        $carousel->title = isset($request->title)?$request->title:'';
        $carousel->sub_title = isset($request->sub_title)?$request->sub_title:'';
        $carousel->type = isset($request->type)?$request->type:1;
        $carousel->sort = isset($request->sort)?$request->sort:1;
        $carousel->is_show = isset($request->is_show)?$request->is_show:1;
        $carousel->url = isset($request->url)?$request->url:'';
        $carousel->third_id = isset($request->third_id)?$request->third_id:1;

         //处理文件上传
        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/carousel')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $carousel->cover = $path;
        }

        if (!$carousel->save()) {
            return $this->error('修改轮播图失败');
        }
        return $this->success('修改轮播图成功');
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

        if (!$res=Carousel::where('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Article;
use App\Models\ArticleType;
use App\Models\ArticleTags;
use App\Models\ArticleImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Common\CommonController;
use App\Http\Controllers\Admin\Common\CacheController;
use League\HTMLToMarkdown\HtmlConverter;


/**
 * 文章控制器
 */
class ArticleController extends CommonController
{
    private $article;//文章对象

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-17
     * 初始化
     */
    public function __construct(){
        $article = new Article();//获取文章对象
        $this->article = $article;
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

        $article = Article::select('*')
                          ->orderBy('created_at','desc')
                          ->where($where)
                          ->paginate(10);

        //获取文章分类
        $articleType = ArticleType::select('id','type_name')
                                  ->get();

        return view('admin.article.list',compact('article','search','articleType','articleTags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $article = $this->article;//获取文章对象

        $articleType = ArticleType::select('id','type_name')->where('parent_id','!=','0')->get();//获取文章分类

        $articleTags = ArticleTags::select('id','tag_name')->get();//获取文章标签

        return view('admin.article.edit',compact('article','articleType','articleTags'));
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
            'title' => 'required|max:255',
            'type' => 'required',
            'content' => 'required',
        ]);

        $article = $this->article;

        $article->title = isset($request->title)?$request->title:'';
        $article->time = isset($request->time)?strtotime($request->time):time();
        $article->is_show = isset($request->is_show)?$request->is_show:0;
        $article->is_up = isset($request->is_up)?$request->is_up:0;
        $article->is_recommend = isset($request->is_recommend)?$request->is_recommend:0;
        $article->article_type = isset($request->article_type)?$request->article_type:0;
        $article->desc = isset($request->desc)?$request->desc:'';
        $article->type = isset($request->type)?$request->type:'';
        $article->user_id = isset($request->user_id)?$request->user_id:Auth::id();
        $article->author = isset($request->author)?$request->author:'';

         //将MarkDown转换成html
        if(isset($request->content)){
            $parsedown = new \Parsedown();
            $parsedown->setSafeMode(true);
            $article->content = $parsedown->text($request->content);
        }else{
            $article->content = '';
        }        

        //判断是否为图片展示类型的文章
        if (isset($request->show_type) || $request->show_type == 2) {
              $article->show_type = 2;
        }else{
            $article->show_type = 1;
        }
        //处理文件上传
        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/article')) {
                   return $this->error('图片存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $article->cover = $path;
        }

        DB::beginTransaction();

        if (!$article->save()) {
            return $this->error('添加文章失败');
        }

        //处理文章图片上传
        $imgs = $request->file('img');
        if (!is_null($imgs)) {
            //开始事务
            foreach ($imgs as $k => $v) {
                  $articleImg = new ArticleImg();
                   try {
                        if (!$path = $this->uploadMoreImageData($v,['png','jpeg','jpg'],'admin/article/img/')) {
                           return $this->error('图片保存失败');
                        }
                    } catch (\Exception $e) {
                        return $this->error($e->getMessage());
                    }

                    $articleImg->img = $path;
                    $articleImg->article_img = $article->id;

                    if (!$articleImg->save()) {
                        DB::rollback();
                        return $this->error('添加文章图片失败');
                    }

            }
        }
        //提交事务
        DB::commit();

        //添加标签
        if (isset($request->tags)) {
            $article->tags()->attach($request->tags);
        }
        return $this->success('添加文章成功');
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
            $article = Article::find($id);
            $article->is_show = 1;
            if(!$article->save()){
                return $this->error('修改失败');
            }
            return $this->success('修改成功');
        }elseif ($is_show == 1) {
            $article = Article::find($id);
            $article->is_show = 0;
            if(!$article->save()){
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

        if (empty($article=Article::find($id))) {
             return $this->error('获取数据失败');
        }

        $articleType = ArticleType::select('id','type_name')->where('parent_id','!=','0')->get();

        $articleTags = ArticleTags::select('id','tag_name')->get();

        $articleImg = ArticleImg::where('article_img',$id)->get();
        //讲Html转换成markdown语法
        $converter = new HtmlConverter();
        $article->content = $converter->convert($article->content);

        return view('admin.article.edit',compact('article','articleTags','articleType','articleImg'));
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

        if (empty($article=Article::find($id))) {
             return $this->error('获取数据失败');
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'type' => 'required',
            'content' => 'required',
        ]);

        $article->title = isset($request->title)?$request->title:'';
        $article->time = isset($request->time)?strtotime($request->time):time();
        $article->is_show = isset($request->is_show)?$request->is_show:0;
        $article->is_up = isset($request->is_up)?$request->is_up:0;
        $article->is_recommend = isset($request->is_recommend)?$request->is_recommend:0;
        $article->desc = isset($request->desc)?$request->desc:'';
        $article->user_id = isset($request->user_id)?$request->user_id:Auth::id();
        $article->author = isset($request->author)?$request->author:'';
        $article->type = isset($request->type)?$request->type:'';
        $article->article_type = isset($request->article_type)?$request->article_type:0;

        //将MarkDown转换成html
        $parsedown = new \Parsedown();
        $parsedown->setSafeMode(true);
        $article->content = isset($request->content)?$parsedown->text($request->content):'';


        //判断是否为图片展示类型的文章
        if (isset($request->show_type) || $request->show_type == 2) {
              $article->show_type = 2;
        }else{
            $article->show_type = 1;
            ArticleImg::where('article_img',$id)->delete();//将该文章的所有文章图片全部删除
        }

        //文件上传
        if ($request->file('cover')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'admin/article')) {
                   return $this->error('图片保存失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $article->cover = $path;
        }

        DB::beginTransaction();
        if (!$article->save()) {
            return $this->error('修改文章失败');
        }
        //处理文章图片上传
        $imgs = $request->file('img');
        if (isset($request->img_id)) {
             foreach ($request->img_id as $k => $v) {
                //判断是否有修改的照片，如果有则进行修改
                if ($request->file('img_'.$v)) {
                    $articleImg = ArticleImg::find($v);
                    if (is_null($articleImg)) {
                        return $this->error('获取文章图片数据失败');
                    }
                       try {
                            if (!$path = $this->uploadImageData('img_'.$v,['png','jpeg','jpg'],'admin/article/img')) {
                               return $this->error('图片保存失败');
                            }
                        } catch (\Exception $e) {
                            return $this->error($e->getMessage());
                        }

                        $articleImg->img = $path;

                        if (!$articleImg->save()) {
                            DB::rollback();
                            return $this->error('修改漫画图片失败');
                        }
                }
            }
        }
        if (!is_null($imgs)) {
            foreach ($imgs as $k => $v) {
                  $articleImg = new ArticleImg();

                   try {
                        if (!$path = $this->uploadMoreImageData($v,['png','jpeg','jpg'],'admin/article/img/')) {
                           return $this->error('图片保存失败');
                        }
                    } catch (\Exception $e) {
                        return $this->error($e->getMessage());
                    }

                    $articleImg->img = $path;
                    $articleImg->article_img = $id;

                    if (!$articleImg->save()) {
                        DB::rollback();
                        return $this->error('添加文章图片失败');
                    }

             }
        }

        DB::commit();

        //修改标签
        if (isset($request->tags)) {
            DB::table('article_tags')->where('article_id',$id)->delete();
            $article->tags()->attach($request->tags);
        }

        return $this->success('修改文章成功');
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

        if (!$res=Article::destroy($id)) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }

}

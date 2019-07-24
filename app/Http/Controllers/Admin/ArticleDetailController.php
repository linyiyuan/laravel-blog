<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Article;
use App\Models\ArticleType;
use App\Models\ArticleTags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Common\CommonController;

/**
 * 文章详情以及文章内容图片上传
 */
class ArticleDetailController extends CommonController
{
    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-16
     * @获取文章内容详情
     * @param     [integer]      $id [文章id]
     */
    public function getDetail($id)
    {
    	if(!intval($id)){
            return $this->error('非法参数');
        }

        if (empty($article=Article::find($id))) {
             return $this->error('获取数据失败');
        }

        //处理得到分类对应id
        $articleType = ArticleType::select('id','type_name')->get();
        $articleType = array_column(json_decode(json_encode($articleType),true), 'type_name','id');

        $articleTags = ArticleTags::select('id','tag_name')->get();

        return view('admin.article.detail',compact('article','articleType','articleTags'));
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-16
     * @上传文章内容图片
     * @param     Request     $request [description]
     */
    public function uploadImage(Request $request)
    {
        $data = Input::all();

        //得到文件
        $img = $data['file'];

        //文件允许的类型
        $imageType = ['image/jpeg','image/jpg','image/png'];

        //文件源名字
        $originalName = $img->getClientOriginalName();

        //文件后缀
        $extension = $img->getClientOriginalExtension();

        //文件绝对路径
        $realPath  = $img->getRealPath();
        //拼接得到图片的名称
        $contentPath = '/ueditor/pic'.'/'.date('Y-m-d',time()).'/'.substr(md5(time()), 12).'.'.$extension;
        //上传图片到七牛云
        $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));

        if ($bool) {
            $imageName = config('app.qiniu_cdn').$contentPath;
            return $imageName;
        }else{
            return '上传图片错误';
        }
    }

     /**
     * @Author    linyiyuan
     * @DateTime  2018-07-16
     * @批量删除文章
     * @param     Request     $request [description]
     */
    public function delMordArtcle(Request $request)
    {

        if (!intval($id=$request->id)) {
             return $this->ajaxResponse('500','非法参数');
        }

        if (!$res=Article::whereIn('id',$id)->delete()) {
           return $this->ajaxResponse('500','删除失败');
        }
        
        return $this->ajaxResponse('200','删除成功');
    }
}    
<?php

namespace App\Http\Controllers\Api;

use App\Jobs\MessagePush;
use App\Models\HomeUsers;
use App\Models\Visitor;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Jobs\SendCommentEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\Common\BaseController;

class CommentController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-08-14
	 * @copyright 添加评论操作
	 */
    public function addComment(Request $request)
    {
    	$comment = [];
    	$content = $request->content;//获取评论内容内容
    	$token = $request->access_token;//获取用户登录token
    	$article_id = $request->article_id;//获取评论文章id
        $user_id = $request->user_id;//被评论者id
        $comment_content_id = $request->comment_id;//评论id

    	if (is_null($token) || empty($token)) {
    		return $this->errorReturn(500,'请先登录');
    	}

    	if (is_null($article_id) || empty($article_id)) {
    		return $this->errorReturn(500,'非法文章id');
    	}

    	$userInfo = HomeUsers::where('access_token',$token)->first();//获取用户信息

        if (is_null($userInfo)){
            return $this->errorReturn(500,'用户失效,请重新登录');
        }


		//验证是否为回复信息
    	$reply = strtok($content, ' ');
    	if (substr($reply, 0,1) == '@') {
    		$type = 2;
    	}else{
    		$type = 1;
    	}

    	//将MarkDown转换成html
        if(isset($content)){
            $parsedown = new \Parsedown();
            $parsedown->setSafeMode(true);
            $content = $parsedown->text($request->content);
        }else{
            return $this->errorReturn(500,'请输入评论内容');
        } 
  
        $comment = new Comment();

        $comment->comment = $content;
        $comment->article_id = $article_id;
        $comment->user_id = $userInfo->id;
        $comment->type = $type;

        if (!$comment->save()) {
        	return $this->errorReturn(500,'评论失败');
        }

        //推送一条消息
        MessagePush::dispatch([
            'user_id' => $comment->user_id,
            'message' => ' ',
            'third_id' => $comment->id,
            'type' => 3
        ]);

        $comment->user_img = $userInfo->avatar;
        $comment->username = $userInfo->nickname;
        
        //判断如果是回复内容则发送邮箱
        if ($type == 2) {
            $data['user_id'] = $user_id;
            $data['comment_content_id'] = $comment_content_id;
            $data['comment'] = $content;
            $data['article_id'] = $article_id;
            $data['userInfo'] = $userInfo;
            //分发发送邮箱队列
            SendCommentEmail::dispatch($data);
        }

    	return $this->successReturn(200,$comment);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-08-14
     * @copyright 删除评论操作
     */
    public function delComment($comment_id,Request $request)
    {
    	$access_token = $request->access_token;//获取用户登录token

    	if (!intval($comment_id)) {
    		return $this->errorReturn(500,'获取评论信息错误');
    	}

    	if (is_null($access_token) || empty($access_token)) {
    		return $this->errorReturn(500,'请先登录');
    	}

    	if (is_null($comment = Comment::find($comment_id))) {
    		return $this->errorReturn(500,'获取评论信息错误');
    	}

    	if ($comment->user_id != userInfo()['id']) {
    		return $this->errorReturn(500,'你没有权限删除该评论');
    	}

    	if (!Comment::where('id',$comment_id)->delete()) {
    		return $this->errorReturn(500,'删除评论失败');
    	}

    	return $this->successReturn(200,'删除评论成功');
    }


    /**
     * @Author    linyiyuan
     * @DateTime  2018-07-16
     * @上传评论内容图片
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
        $contentPath = '/comment/pic'.'/'.date('Y-m-d',time()).'/'.substr(md5(time()), 12).'.'.$extension;
        //上传图片到七牛云
        $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));

        if ($bool) {
            $imageName = config('app.qiniu_cdn').$contentPath;
            return $imageName;
        }else{
            return '上传图片错误';
        }
    }
}

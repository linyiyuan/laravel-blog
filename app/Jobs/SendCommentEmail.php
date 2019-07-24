<?php

namespace App\Jobs;

use App\Models\HomeUsers;
use App\Models\Visitor;
use App\Models\Comment;
use App\Mail\CommentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendCommentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;//被评论者的user_id
    protected $comment_content_id;//评论的内容id
    protected $comment;//回复内容
    protected $article_id;//回复的文章id
    protected $userInfo;//评论用户的信息


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->comment_content_id = $data['comment_content_id'];
        $this->comment = $data['comment'];
        $this->article_id = $data['article_id'];
        $this->userInfo = $data['userInfo'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $comment_user = HomeUsers::find($this->user_id);//拿到被评论者的user_id
        $comment_content = Comment::find($this->comment_content_id);
        //判断是否有邮箱
        if (empty($comment_user->email) || is_null($comment_user->email)) {
            return false;
        }
        Mail::to($comment_user->email)->send(new CommentMail($comment_content->comment,$this->comment,env('APP_URL').'/article/'.$this->article_id,$this->userInfo->username));
    }
}

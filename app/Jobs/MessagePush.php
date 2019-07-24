<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\Models\HomeUsers;
use App\Models\Msg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PhpOffice\PhpWord\Element\Object;

/**
 * Class MessagePush
 * @package App\Jobs
 * 消息通知队列
 */
class MessagePush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     * 关联用户id
     */
    private $user_id;

    /**
     * @var string
     * 消息内容
     */
    private $message;

    /**
     * @var string
     * 消息类型
     */
    private $type;

    /**
     * @var string
     * 第三方关联Id
     */
    private $third_id;//第三方关联id

    /**
     * @var Object
     * 用户信息
     */
    private $userInfo;//用户信息

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        if (empty($params)) return false;

        $this->user_id = $params['user_id'] ?? '';
        $this->message = $params['message'] ?? '';
        $this->type = $params['type'] ?? '';
        $this->third_id = $params['third_id'] ?? '';

        //获取用户信息
        if (!empty($this->user_id)) $this->userInfo = HomeUsers::find($this->user_id)->toArray();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         switch ( $this->type){
             case 0:
                 $this->message = '收到了一条新信息' . $this->message;
             break;
             case 1:
                 $this->message = '收到了一条新用户注册信息，该新用户名为 ' . $this->userInfo['nickname'] . '';
             break;
             case 2:
                 $this->message = '收到了一条新的留言信息，' . $this->userInfo['nickname'] . '在你博客中留言了，';
             break;
             case 3:
                 $comment = Comment::find($this->third_id)->toArray();
                 $article = Article::find($comment['article_id'])->toArray();
                 $this->message = '收到了一条新的评论信息, ' . $this->userInfo['nickname'] . '评论了你的文章：'. $article['title'] . '';
             break;
             case 4:
                 $article = Article::find($this->third_id)->toArray();
                 $this->message = $this->userInfo['nickname'] . '赞了你的文章：' . $article['title'];
             break;
         }
        // 生成一条新消息
        $msg = new Msg();
        $msg->user_id = $this->user_id;
        $msg->message = $this->message;
        $msg->type = $this->type;
        $msg->third_id = $this->third_id;
        if (!$msg->save()) return false;
    }

}


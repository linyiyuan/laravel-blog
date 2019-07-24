<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * comment 实例。
     *
     * @var Order
     */
    protected $reply_comment;//回复内容
    protected $comment; //被回复内容
    protected $artcile_url; //评论文章url
    protected $comment_user; //评论者


    /**
     * 创建一个新消息实例。
     *
     * @return void
     */
    public function __construct($comment,$reply_comment,$artcile_url,$comment_user)
    {
        $this->comment = $comment;
        $this->reply_comment = $reply_comment;
        $this->artcile_url = $artcile_url;
        $this->comment_user = $comment_user;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        //去掉头部艾特
        $comment_header = strtok($this->comment,' ');
        $this->comment = str_replace($comment_header, '', $this->comment);

        $reply_header = strtok($this->reply_comment,' ');
        $this->reply_comment = str_replace($reply_header, '', $this->reply_comment);

        return $this->view('emails.comment')
                    ->subject($this->comment_user.'回复了你的评论，请查看')
                    ->with([
                        'comment' => $this->comment,
                        'reply_comment' => $this->reply_comment,
                        'artcile_url' => $this->artcile_url,
                        'comment_user' => $this->comment_user,
                    ]);
        // return $this->text('emails.orders.shipped_plain');
    }
}

<div>
    {{ $comment_user }} 回复了你的评论：<p><a href="{{ $artcile_url }}" targer="_blank">{!! $comment !!}</a></p><br>

    <p>内容如下：</p>

    <p>{!! $reply_comment !!}</p>

    <p>---------------------</p>

    <p><a href="{{ env('APP_URL')}}">狗达与佩唲</a></p>
</div>
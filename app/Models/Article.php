<?php

namespace App\Models;

use DB;
use App\Events\ArticleCache;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $user_id 管理员id
 * @property string $title 文章标题
 * @property string $desc 文章描述
 * @property string $content 文章内容
 * @property int $type 文章分类 0:无
 * @property int $time 发布时间
 * @property int $click 点击次数
 * @property int $article_type 文章的模式类型 0:私有 1:公开
 * @property int $is_show 是否展示 0:否 1:是
 * @property int $is_up 是否置顶:0为否，1是
 * @property int $is_recommend 是否为博主推荐:0为否，1为是
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $author 作者
 * @property string $cover 文章封面图片
 * @property int $praise 文章点赞数
 * @property int $share 文章分享数
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ArticleTags[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereArticleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereIsRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereIsUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePraise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereShare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUserId($value)
 * @mixin \Eloquent
 */
class Article extends Model
{

	protected $table = 'article';

    /**
     * 获得此文章的所有标签
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\ArticleTags','article_tags','article_id', 'tag_id');
    }


    /**
     * @Author    linyiyuan
     * @DateTime  2018-06-21
     * 判断是否有标签
     */
    public function hasTags($tags_id)
    {
    	$res = DB::table('article_tags')->where([['tag_id',$tags_id],['article_id',$this->id]])->limit(1)->first();

    	if (is_null($res)) {
    		return false;
    	}
    	
    	return true;
    }

}

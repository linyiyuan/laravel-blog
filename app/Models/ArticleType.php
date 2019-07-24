<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleType
 *
 * @property int $id
 * @property string $type_name 分类名称
 * @property string $desc 分类描述
 * @property int $is_show 是否展示
 * @property int $sort 顺序
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleType extends Model
{
   protected $table = 'article_type';
}

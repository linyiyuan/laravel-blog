<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleTags
 *
 * @property int $id
 * @property string $tag_name 标签名字
 * @property string $tag_desc 标签描述
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleTags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleTags whereTagDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleTags whereTagName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleTags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleTags extends Model
{
    protected $table = 'tags';
}

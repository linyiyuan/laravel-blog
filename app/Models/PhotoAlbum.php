<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PhotoAlbum
 *
 * @property int $id
 * @property string $name 相册名
 * @property string $desc 相册描述
 * @property string $cover 相册封面图
 * @property int $type 相册分类
 * @property int $photo_permission 相册权限 0:所有人可以见 1:回答问题可以见 2:仅自己可以见
 * @property string|null $question 问题
 * @property string|null $answer 答案
 * @property string $author 相册作者
 * @property int $praise 相册点赞数
 * @property int $click 相册浏览数
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum wherePhotoPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum wherePraise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbum whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PhotoAlbum extends Model
{
    protected $table = 'photo_album';
}

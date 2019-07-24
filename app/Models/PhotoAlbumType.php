<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PhotoAlbumType
 *
 * @property int $id
 * @property string $type_name 分类名称
 * @property string $desc 分类描述
 * @property int $is_show 是否展示
 * @property int $sort 顺序
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhotoAlbumType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PhotoAlbumType extends Model
{
    protected $table = 'photo_album_type';
}

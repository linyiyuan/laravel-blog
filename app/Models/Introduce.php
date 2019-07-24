<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Introduce
 *
 * @property int $id
 * @property string $screen_names 网名
 * @property string $profession 职业
 * @property string $weixi 个人微信
 * @property string $email 邮箱
 * @property string $qq qq
 * @property string $introduce
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $resume 个人简历地址
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereResume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereScreenNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Introduce whereWeixi($value)
 * @mixin \Eloquent
 */
class Introduce extends Model
{
    protected $table = 'introduce';
}

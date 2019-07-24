<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OperationLog
 *
 * @property int $id
 * @property string $username 登录用户名
 * @property string $role 角色
 * @property string $ip 登录ip
 * @property int $result 结果  0:代表失败 1:代表成功
 * @property string $operate 操作 1:登录操作 2:增加操作 3:修改操作 4:删除操作
 * @property string $detail 操作详情
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereOperate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OperationLog whereUsername($value)
 * @mixin \Eloquent
 */
class OperationLog extends Model
{
    protected $table = 'operation_log';
}

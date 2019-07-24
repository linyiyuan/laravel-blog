<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('operation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->default('')->comment('登录用户名');
            $table->string('role')->default('')->comment('角色');
            $table->string('ip')->default('')->comment('登录ip');
            $table->tinyInteger('result')->default('1')->comment('结果  0:代表失败 1:代表成功');
            $table->string('operate')->default('0')->comment('操作 1:登录操作 2:增加操作 3:修改操作 4:删除操作');
            $table->string('detail')->default('')->comment('操作详情');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_log');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default('0')->comment('用户关联id');
            $table->integer('third_id')->default('0')->comment('第三方关联id');
            $table->string('message',500)->default('无')->comment('消息内容');
            $table->tinyInteger('type')->default('0')->comment('消息类型 0：默认 1：注册消息 2：留言消息 3：评论消息 4:赞文章');
            $table->tinyInteger('status')->default('0')->comment('消息状态 0：未读 1：已读');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.1
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msg');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default('1')->comment('管理员id');
            $table->string('title')->default('')->comment('文章标题');
            $table->string('desc')->default('')->comment('文章描述');
            $table->text('content')->comment('文章内容');
            $table->integer('type')->default('0')->comment('文章分类 0:无');
            $table->string('tags',500)->default('0')->comment('文章标签 用,隔开有多个');
            $table->integer('time')->default('0')->comment('发布时间');
            $table->integer('click')->default('0')->comment('点击次数');
            $table->tinyinteger('article_type')->default(0)->comment('文章的模式类型 0:私有 1:公开');
            $table->tinyinteger('is_show')->default(0)->comment('是否展示 0:否 1:是');
            $table->tinyinteger('is_up')->default(0)->comment('是否置顶:0为否，1是');
            $table->tinyinteger('is_recommend')->default(0)->comment('是否为博主推荐:0为否，1为是 ');
            $table->index('type');
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
        Schema::dropIfExists('article');
    }
}

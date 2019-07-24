<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('轮播图上标题');
            $table->string('sub_title')->default('')->comment('轮播图内容');
            $table->tinyinteger('type')->default('1')->comment('轮播图类型 1:默认 2:广告 3:文章 4:链接');
            $table->string('third_id')->default(0)->comment('文章ID或者url');
            $table->string('cover')->default('')->comment('轮播图封面图');
            $table->tinyinteger('is_show')->default('1')->comment('是否显示，1：显示 2：隐藏');
            $table->tinyinteger('sort')->default('1')->comment('顺序，从小到大排序');
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
        Schema::dropIfExists('carousel');
    }
}

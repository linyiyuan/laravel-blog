<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_album', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('相册名');
            $table->string('desc',500)->default('')->comment('相册描述');
            $table->string('cover',500)->default('')->comment('相册封面图');
            $table->integer('type')->default('0')->comment('相册分类');
            $table->tinyinteger('photo_permission')->default('0')->comment('相册权限 0:所有人可以见 1:回答问题可以见 2:仅自己可以见');
            $table->string('question',1000)->default('')->nullable()->comment('问题');
            $table->string('answer',1000)->default('')->nullable()->comment('答案');
            $table->string('author',255)->default('')->comment('相册作者');
            $table->integer('praise')->default('0')->comment('相册点赞数');
            $table->integer('click')->default('0')->comment('相册浏览数');
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
        Schema::dropIfExists('photo_album');
    }
}

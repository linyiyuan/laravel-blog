<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoAlbumTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_album_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name')->default('')->comment('分类名称');
            $table->string('desc')->default('')->comment('分类描述');
            $table->tinyinteger('is_show')->default('1')->comment('是否展示');
            $table->tinyinteger('sort')->default('0')->comment('顺序');
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
        Schema::dropIfExists('photo_album_type');
    }
}

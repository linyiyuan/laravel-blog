<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->default('')->comment('用户登录名');
            $table->string('userpass')->default('')->comment('用户登录密码');
            $table->string('phone')->default('')->comment('用户手机号码');
            $table->string('lastloginip')->default('')->comment('用户登录ip');
            $table->integer('lastlogintime')->comment('用户上次登录时间');
            $table->string('email')->default('')->comment('用户邮箱');
            $table->tinyinteger('status')->default('1')->comment('用户状态 1:正常 2:冻结');
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
        Schema::dropIfExists('visitor');
    }
}

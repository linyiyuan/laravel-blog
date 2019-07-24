<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->default('')->comment('用户名');
            $table->string('open_id')->default('')->comment('openid');
            $table->string('phone')->default('')->comment('用户手机号码');
            $table->string('lastloginip')->default('')->comment('用户登录ip');
            $table->integer('lastlogintime')->comment('用户上次登录时间');
            $table->string('email')->default('')->comment('用户邮箱');
            $table->string('access_token')->default('')->comment('access_token');
            $table->string('avatar')->default('')->comment('用户头像');
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
        Schema::dropIfExists('home_users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntroduceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introduce', function (Blueprint $table) {
            $table->increments('id');
            $table->string('screen_names',255)->comment('网名')->default('');
            $table->string('profession')->comment('职业')->default('');
            $table->string('weixi')->comment('个人微信')->default('');
            $table->string('email')->comment('邮箱')->default('');
            $table->string('qq')->comment('qq')->default('');
            $table->text('introduce');
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
        Schema::dropIfExists('introduce');
    }
}

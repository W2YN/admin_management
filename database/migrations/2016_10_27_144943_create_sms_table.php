<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smss', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->string('mobiles',255)->comment('手机号码，最大支持32个，用逗号隔开');
            $table->string('content',512)->comment('短信内容');
            $table->timestamp('opertion_time')->comment('发送时间');
            $table->integer('is_send')->default(0)->comment('是否已发送');
            $table->integer('status')->default(0)->comment('状态(0:未发送;1:发送中;2:已发送;3:发送失败)');
            $table->integer('channel')->default(0)->comment('发送通道');
            $table->integer('error_count')->default(0)->comment('失败次数');
            $table->softDeletes();
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
        Schema::drop('smss');
    }
}

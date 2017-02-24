<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            //创建message表
            $table->increments("id");
            $table->integer("from")->comment("消息来源id");
            $table->integer("to")->comment("消息到达id");
            $table->string('from_name', 30)->comment("来源名称");
            $table->string('to_name', 30)->comment("到达名称");
            $table->string("title", 50)->comment("消息标题"); //后续添加
            $table->string("content", 1024)->comment("消息内容");
            $table->string("level", 30)->comment("紧急程度"); //后需添加
            $table->integer("is_read")->comment("是否已读取,0->未读取,1->已读取");
            //$table->integer("is_delete")->comment("是否已删除,软删除,0->未删除,1->已删除");
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
        Schema::drop("messages");
    }
}

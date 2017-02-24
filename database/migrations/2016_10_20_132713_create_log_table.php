<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_logs', function (Blueprint $table) {
            //创建log表
            $table->increments("id");
            $table->integer("user_id")->comment("操作者id");
            $table->string("type", 30)->comment("操作分类: 合同管理，净水器，车险分期等"); //字符串就好
            $table->string("url", 100)->comment("操作url");
            $table->string("method",10)->comment("提交url的方式,get|post|put|delete|等");
            $table->string("params", 100)->comment("提交时附加的参数信息(过大的处理?)");
            $table->string('desc', 400)->comment("操作描述");
            //$table->integer("is_delete")->comment("删除标志，软删除,0->未删除,1->已删除");
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
        Schema::drop("operation_logs");
    }
}

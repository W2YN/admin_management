<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_wx_official_accounts')->create('wx_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 64)->comment('微信OpenID');
            //后期加上其他参数
            $table->integer('is_load')->default(0)->comment('已经读取基本信息');
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
        Schema::connection('mysql_wx_official_accounts')->drop('wx_members');
    }
}

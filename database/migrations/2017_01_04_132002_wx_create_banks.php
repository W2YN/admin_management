<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class WxCreateBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_wx_official_accounts')->create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank', 32)->comment('银行名称');
            $table->string('from',32)->comment('接口提供方');
            $table->string('code',32)->comment('唯一识别码');
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
        Schema::connection('mysql_wx_official_accounts')->drop('banks');
    }
}

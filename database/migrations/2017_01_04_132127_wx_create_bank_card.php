<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class WxCreateBankCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_wx_official_accounts')->create('bank_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('用户ID');
            $table->string('name', 20)->comment('持卡人姓名');
            $table->string('id_number', 24)->comment('持卡人身份证号码');
            $table->integer('bank_id')->comment('开户银行编号');
            $table->string('bank_number', 32)->comment('银行卡卡号');
            $table->enum('type', ['储蓄卡', '信用卡'])->default('储蓄卡')->comment('类别:1:储蓄卡,2:信用卡');
            $table->string('mobile', 11)->comment('手机号码');
            $table->string('last_verify_code', 6)->comment('最后一次验证码');
            $table->timestamp('bind_time')->comment('绑定时间');
            $table->string('from', 32)->comment('接口提供方');
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
        Schema::connection('mysql_wx_official_accounts')->drop('bank_card');

    }
}

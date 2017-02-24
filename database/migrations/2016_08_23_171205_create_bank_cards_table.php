<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('bank_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card',32)->comment('卡号');
            $table->string('name',64)->comment('持卡人姓名');
            $table->string('id_number',64)->comment('持卡人身份证信息');
            $table->string('phone_number',64)->comment('预留手机号码');
            $table->string('bank_id',16)->comment('发卡行');
            $table->string('wx_openid','32')->comment('微信openID');
            $table->string('verify_code',64)->comment('验证码');
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
        Schema::connection('mysql_water_purifier')->drop('bank_cards');
    }
}

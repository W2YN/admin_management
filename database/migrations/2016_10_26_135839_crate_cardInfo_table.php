<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CrateCardInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('card_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->comment('订单ID');
            $table->text('card', 32)->comment('卡号');
            $table->text('name', 64)->comment('持卡人姓名');
            $table->text('id_number', 32)->comment('持卡人身份证信息');
            $table->text('phone_number', 11)->comment('预留手机号码');
            $table->tinyInteger('cvn_number')->comment('CVN安全码');
            $table->text('card_validity', 16)->comment('信用卡有效期');
            $table->dateTime('last_check')->comment('最后一次有效性');
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
        Schema::connection('mysql_car_insurance')->drop('card_info');
    }
}

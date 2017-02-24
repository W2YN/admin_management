<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizeOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_wx_official_accounts')->create('wx_prize_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("member_id")->comment("用户id");
            $table->integer("prize_id")->comment("奖品id");
            $table->string("prize_name", 30)->comment("奖品名称");
            $table->integer("medal_cost_number")->comment("消耗的勋章数量");
            $table->integer("prize_number")->comment("购买的勋章数量");
            $table->integer("status")->comment("订单状态");//无用
            $table->string("order_num", 30)->comment("订单号");
            $table->integer("address_id")->comment("送单地址");
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
        //
        Schema::connection('mysql_wx_official_accounts')->drop('wx_prize_order');
    }
}

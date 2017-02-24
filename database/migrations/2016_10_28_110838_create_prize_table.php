<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_wx_official_accounts')->create('wx_prize', function (Blueprint $table) {
            $table->increments('id');
            $table->string("url", 100)->comment("奖品地址");
            $table->string("name", 30)->comment("奖品名称");
            $table->integer('order')->comment("排序之用");
            $table->integer("medal_exchange_number")->comment("兑换需要的勋章数量");
            $table->string("desc", 100)->comment("商品描述");
            $table->timestamps();
            //$table->string("receiver_name", 30)->comment("收货人姓名");
            //$table->string("mobile", 11)->comment("收货人手机号");
            //$table->string("area", 50)->comment("所在区");
            //$table->string("city", 20)->comment("所在市");
            //$table->string("province",20)->comment("所在省");
            //$table->string('address_detail', 150)->comment("收货人详细地址");
            //$table->integer("is_default")->comment("是否是默认地址");

            //$table->timestamps();
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
        Schema::connection('mysql_wx_official_accounts')->drop('wx_prize');
    }
}

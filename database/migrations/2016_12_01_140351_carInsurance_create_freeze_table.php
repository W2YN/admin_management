<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceCreateFreezeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('freeze', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("order_id")->comment("订单id");
            $table->integer("money")->comment("冻结金额");
            $table->string("freeze_queryid", 128)->comment("冻结流水号");
            $table->dateTime("datetime")->comment("冻结时间");
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
        Schema::connection('mysql_car_insurance')->drop('freeze');
    }
}

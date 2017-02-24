<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlterOrderAddErrorColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //错误标志
            $table->integer("error")->comment("错误标志");
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
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //删除错误标志
            $table->dropColumn('error');
        });
    }
}

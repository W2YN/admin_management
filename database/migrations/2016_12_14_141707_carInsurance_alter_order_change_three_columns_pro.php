<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlterOrderChangeThreeColumnsPro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->string('car_model', 32)->change();
            $table->string('car_engine_num', 64)->change();
            $table->string('car_vin_code', 32)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
        });
    }
}

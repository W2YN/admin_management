<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WaterPurifierAlertWaterPurifierAddError extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->integer('error')->comment('支付异常标志');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->dropColumn('error');
        });
    }
}

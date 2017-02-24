<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlertWaterPuriferSalesAddDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('sales', function (Blueprint $table) {
            $table->integer('discount_type')->comment('优惠类型');
            $table->integer('discount_value')->comment('优惠值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_water_purifier')->table('sales', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            $table->dropColumn('discount_value');
        });

    }
}

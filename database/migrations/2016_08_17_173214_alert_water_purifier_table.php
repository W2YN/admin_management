<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertWaterPurifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->string('num','64')->unique()->comment('订单号');
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
            $table->dropColumn('num');
        });
    }
}

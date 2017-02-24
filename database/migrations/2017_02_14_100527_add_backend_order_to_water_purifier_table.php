<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackendOrderToWaterPurifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->integer('backend_order')->default(0)->comment('后台订单(0:微信端生成;1:后台创建)');
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
            $table->dropColumn('backend_order');
        });
    }
}

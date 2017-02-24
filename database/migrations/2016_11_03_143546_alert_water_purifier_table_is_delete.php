<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertWaterPurifierTableIsDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->integer('is_delete')->comment('订单已经删除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('water_purifier', function (Blueprint $table) {
            $table->dropColumn('is_delete');
        });
    }
}

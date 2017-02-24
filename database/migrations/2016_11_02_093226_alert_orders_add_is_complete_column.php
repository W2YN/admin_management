<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertOrdersAddIsCompleteColumn extends Migration
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
            $table->integer("is_complete")->comment("是否完成,0->未完成，1->已完成");
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
            $table->dropColumn('is_complete');
        });
    }
}

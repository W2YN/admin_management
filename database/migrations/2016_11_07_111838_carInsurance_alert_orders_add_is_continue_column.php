<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlertOrdersAddIsContinueColumn extends Migration
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
            $table->integer('is_continue')->comment('是否为续保');
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
            $table->dropColumn('is_continue');
        });
    }
}

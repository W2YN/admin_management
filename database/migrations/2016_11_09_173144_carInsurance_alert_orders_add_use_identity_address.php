<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlertOrdersAddUseIdentityAddress extends Migration
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
            $table->integer('use_identity_address')->comment("是否使用身份证地址作为客户地址信息,0->不是，1->是");
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
            $table->dropColumn('use_identity_address');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceCreateRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('recommends', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('user_id')->comment("关联的用户id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_car_insurance')->drop('recommends');
        //Schema::table('recommends', function (Blueprint $table) {
            //
        //});
    }
}

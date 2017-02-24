<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceModifyOrderTableAddRecommendColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->string('recommend_name', 25)->comment("推荐人名称");
            $table->integer("recommend_id")->comment("推荐人id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('recommend_name');
            $table->dropColumn('recommend_id');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceOrderAddStoreImageColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //添加三个字段用于存储图片路径
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->string('business_money_image', 255)->comment('商业险图片');
            $table->string('force_money_image', 255)->comment('商业险图片');
            $table->string('other_image', 255)->comment('其他保单图片');
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
            $table->dropColumn('business_money_image');
            $table->dropColumn('force_money_image');
            $table->dropColumn('other_image');
        });
    }
}

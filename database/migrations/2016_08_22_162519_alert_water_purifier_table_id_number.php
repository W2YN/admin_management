<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertWaterPurifierTableIdNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('water_purifier', function (Blueprint $table) {
            $table->string('id_number','64')->comment('身份证号');
            $table->string('id_number_img','255')->comment('身份证照片');
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
            $table->dropColumn('id_number');
            $table->dropColumn('id_number_img');
        });
    }
}

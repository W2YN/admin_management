<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintainsTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('maintains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('water_purifier_id')->comment('净水器编号');
            $table->integer('device_id')->comment('设备ID');
            $table->timestamp('datetime')->comment('维护时间');
            $table->integer('is_complete')->comment('是否完成维护');
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
        Schema::connection('mysql_water_purifier')->drop('maintains');
    }
}

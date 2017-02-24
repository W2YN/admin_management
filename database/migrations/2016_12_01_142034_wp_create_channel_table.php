<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WpCreateChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->default('')->unique();
            $table->string('password', 255)->default('');
            $table->string('from_type', 16)->default('')->unique();
            $table->string('intro')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_water_purifier')->drop('channels');
    }
}

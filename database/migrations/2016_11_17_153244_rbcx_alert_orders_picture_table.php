<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RbcxAlertOrdersPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_rbcx')->table('order', function (Blueprint $table) {
            $table->string('firstpicture')->comment('第一张图');
            $table->string('secondpicture')->comment('第二张图');
            $table->string('thirdpicture')->comment('第三章图');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_rbcx')->table('order', function (Blueprint $table) {
            $table->dropColumn('firstpicture')->comment('第一张图');
            $table->dropColumn('secondpicture')->comment('第二张图');
            $table->dropColumn('thirdpicture')->comment('第三章图');
        });
    }
}

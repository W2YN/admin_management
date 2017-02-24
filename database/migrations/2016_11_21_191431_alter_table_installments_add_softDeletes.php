<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInstallmentsAddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('installments', function (Blueprint $table) {
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
        Schema::connection('mysql_water_purifier')->table('installments', function (Blueprint $table) {
        	$table->dropColumn('deleted_at');
        });
    }
}

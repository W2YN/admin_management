<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceOperationLogsChangeParamsLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operation_logs', function (Blueprint $table) {
            //
            //$table->dropColumn('params');
            $table->string('params', 1000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operation_logs', function (Blueprint $table) {
            //
            //$table->dropColumn('params');
        });
    }
}

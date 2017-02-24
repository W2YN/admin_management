<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBankCardsAddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->table('bank_cards', function (Blueprint $table) {
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
        Schema::connection('mysql_water_purifier')->table('bank_cards', function (Blueprint $table) {
        	$table->dropColumn('deleted_at');
        });
    }
}

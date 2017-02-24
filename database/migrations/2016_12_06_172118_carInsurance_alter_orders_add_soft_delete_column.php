<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlterOrdersAddSoftDeleteColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->softDeletes();
            //$table->dropColumn('');到底要不要把is_delete删除呢，还是得留着
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_car_insurance')->table('orders', function (Blueprint $table) {
            //
            $table->dropColumn("deleted_at");
        });
    }
}

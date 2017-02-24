<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceAlterInstallmentMoneyToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_car_insurance')->table('installment', function (Blueprint $table) {
            //
            $table->integer('money')->change();//使money从decimal变为int
            $table->integer('debit_money')->change();//使money从decimal变为int
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
    }
}

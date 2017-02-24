<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertContractsBankArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('bank_province',32)->comment('开户行省');
            $table->string('bank_city',32)->comment('开户行市');
            $table->string('bank_area',32)->comment('开户行地区');
            $table->string('bank_code',32)->comment('开户行代码');
            $table->integer('bank_type')->comment('账户类型');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('bank_province');
            $table->dropColumn('bank_city');
            $table->dropColumn('bank_area');
            $table->dropColumn('bank_code');
            $table->dropColumn('bank_type');
        });
    }
}

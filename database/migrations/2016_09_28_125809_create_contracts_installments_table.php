<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->comment('合同ID');
            $table->timestamp('opertion_time')->comment('支付时间');
            $table->integer('money')->comment('支付金额');
            $table->integer('status')->comment('状态(0:未支付;1:已支付)');
            $table->integer('type')->comment('类型(0:利息;1:本金)');
            $table->string('remark')->comment('备注');
            $table->softDeletes();
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
        Schema::drop('contract_installments');
    }
}

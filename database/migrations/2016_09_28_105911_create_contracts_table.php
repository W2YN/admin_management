<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32)->comment('姓名');
            $table->string('mobile',16)->comment('电话');
            $table->string('number',32)->comment('合同编号');
            $table->integer('amount')->comment('金额(单位分)');
            $table->integer('count')->comment('期数');
            $table->integer('interest')->comment('利息');
            $table->date('buy_date')->comment('购买日期');
            $table->integer('source')->comment('来源');
            $table->date('expiry_date')->comment('到期日期');
            $table->integer('payment_day')->comment('利息支付日');
            $table->string('bank_card',32)->comment('银行账户');
            $table->string('bank_name',64)->comment('银行名称');
            $table->integer('is_confirm')->comment('确认');
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
        Schema::drop('contract');
    }
}

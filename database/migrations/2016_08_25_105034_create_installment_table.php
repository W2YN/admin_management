<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('water_purifier_id')->comment('净水器订单');
            $table->timestamp('opertion_time')->comment('扣款时间');
            $table->integer('money')->comment('扣款金额');
            $table->integer('debit_money')->comment('已扣金额');
            $table->integer('status')->comment('状态(0:未扣款;1:扣款中;2:已扣款)');
            $table->integer('error_count')->comment('失败次数');
            $table->string('remark')->comment('备注');
            $table->integer('card_id')->comment('扣款卡ID');
            $table->integer('liandong_order_id')->comment('联动支付ID');
            $table->integer('liandong_order_order_id')->comment('联动支付订单号');
            $table->integer('first_pay')->comment('首次支付');
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
        Schema::connection('mysql_water_purifier')->drop('installments');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateInstallmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('installment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->comment('订单ID');
            $table->dateTime('opertiontime')->comment('扣款时间');
            $table->decimal('money')->comment('扣款金额');
            $table->decimal('debit_money')->comment('已扣金额');
            $table->tinyInteger('status')->comment('状态(0:未扣款;1:扣款中;2:已扣款)');
            $table->tinyInteger('type')->comment('类型(1:商业险;2:强制险;3:车船税)');
            $table->tinyInteger('error_count')->comment('失败次数');
            $table->text('remark')->comment('备注');
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_car_insurance')->drop('installment');
    }
}

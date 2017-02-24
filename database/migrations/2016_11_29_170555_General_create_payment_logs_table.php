<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GeneralCreatePaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('payment_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("order_id")->comment("订单id");
            $table->string("order_num", 64)->comment("订单号");
            $table->integer("installment_id")->comment("分期ID");
            $table->dateTime("freeze_time")->comment("冻结时间");
            $table->integer("freeze_money")->comment("冻结金额");
            $table->string("freeze_queryId", 128)->comment("冻结流水号");
            $table->integer("status")->comment("状态,0->生成，1->完成,2->撤销,3->实时扣款");
            $table->string("request_data", 1024)->comment("请求数据");
            $table->string('retCode', 32)->comment("请求返回码");
            $table->string('retDesc', 128)->comment('返回码文本描述');
            $table->string("orderNum", 128)->comment("请求订单编号");
            $table->string("orderStatus", 16)->comment("订单状态 0:已接受, 1:处理中,2:处理成功,3:处理失败");
            $table->string('queryId', 64)->comment("平台返回流水号");
            $table->dateTime("processTime")->comment("系统处理日期");

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
        Schema::connection('mysql_car_insurance')->drop('payment_logs');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiandongOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('liandong_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id', 64)->unique()->comment('订单号');
            $table->string('media_id', 16)->comment('手机号码');
            $table->timestamp('order_date')->comment('订单日期');
            $table->integer('orig_amt')->comment('金额');
            $table->string('last_card_id', 8)->comment('卡号末4位');
            $table->string('installment_ids', 255)->comment('分期ID，多笔时用逗号隔开');
            $table->integer('water_purifier_id')->comment('净水器订单编号');
            $table->integer('status')->default('0')->comment('主状态(0;未扣款;1:已提交;2:已扣款)');
            $table->integer('liandong_pay_file_id')->default('0')->comment('文件包ID');
            $table->integer('ret_state')->default('0')->comment('服务器返回状态吗');
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
        Schema::connection('mysql_water_purifier')->drop('liandong_order');
    }
}

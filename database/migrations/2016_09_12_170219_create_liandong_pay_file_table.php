<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiandongPayFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('liandong_pay_file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name', 128)->comment('文件名');
            $table->integer('busi_type')->comment('交易类型(02:催缴;03:直扣;05:转账;06:提现)');
            $table->timestamp('req_date', 64)->comment('请求日期');
            $table->integer('status')->comment('状态号(0:默认;1:异常)');
            $table->integer('serial_number')->comment('每日流水号');
            $table->string('ret_msg',128)->comment('错误信息');
            $table->string('ret_code',16)->comment('错误码');
            $table->integer('is_delete')->comment('删除标志');
            $table->string('is_delete_remark',255)->comment('删除备注');
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
        Schema::connection('mysql_water_purifier')->drop('liandong_pay_file');
    }
}

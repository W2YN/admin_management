<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialExpressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('mysql_financial')->hasTable('financial_express')) {
    		Schema::connection('mysql_financial')->create('financial_express', function (Blueprint $table){
    			$table->engine = "InnoDB";
    			$table->comment = '快递表';
    			
    			$table->increments('id');
    			$table->string('number', 255)->default('')->comment('快递单号');
    			$table->smallInteger('express_company_id')->default(0)->unsigned()->comment('快递公司id');
    			$table->integer('manager_id')->default(0)->unsigned()->comment('发快递者id');
    			$table->string('manager_name', 128)->default('')->comment('发快递者名称');
    			$table->integer('financial_user_id')->default(0)->unsigned()->comment('收快递者id');
    			$table->timestamp('send_time')->default('0000-00-00 00:00:00')->comment('快递发送日期');
    			$table->timestamp('arrive_time')->default('0000-00-00 00:00:00')->comment('快递收到日期');
    			$table->tinyInteger('status')->default(1)->unsigned()->comment('邮寄中(1) 已收取(2)');
    			$table->timestamps();
    			$table->softDeletes();
    			
    			$table->index('manager_id');
    			$table->index('financial_user_id');
    			$table->index(['send_time', 'arrive_time']);
    			$table->index('number');
    		});
    	}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_financial')->drop('financial_express');
    }
}

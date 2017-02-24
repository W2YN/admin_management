<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if (!Schema::connection('mysql_financial')->hasTable('financial_contract')) {
    		Schema::connection('mysql_financial')->create('financial_contract', function (Blueprint $table){
    			$table->engine = "InnoDB";
    			$table->comment = '合同表';
    			
    			$table->increments('id');
    			$table->string('serial_number', 128)->default('')->comment('合同编号');
    			$table->tinyInteger('type_id')->default(1)->unsigned()->comment('合同类型 a类型(1) b类型(2)...类似');
    			$table->integer('manager_id')->default(0)->unsigned()->comment('建立合同人id');
    			$table->string('manager_name', 128)->default('')->comment('建立合同人名称');
    			$table->integer('financial_user_id')->default(0)->unsigned()->comment('销售方id');
    			$table->integer('express_id')->default(0)->comment('快递id');
    			$table->tinyInteger('status')->default(1)->unsigned()->comment('合同状态 邮寄中(1) 备用(2) 使用中(3) 回邮中(4) 回邮已收到(5) 归档(6) 异常(7)');
    			$table->tinyInteger('exception_status')->default(0)->unsigned()->comment('合同异常状态 无异常(0) 作废(1) 缺失(2) 填错(3)...类似');
    			$table->string('exception_info', 255)->default('')->comment('异常说明');
    			$table->smallInteger('express_company_id')->default(0)->unsigned()->comment('回邮快递公司id');
    			$table->string('express_number', 255)->default('')->comment('回邮快递单号');
    			$table->timestamp('express_send_time')->default('0000-00-00 00:00:00')->comment('回邮快递发件时间');
    			$table->timestamp('express_arrive_time')->default('0000-00-00 00:00:00')->comment('回邮快递收件时间');
    			$table->timestamp('sign_time')->default('0000-00-00 00:00:00')->comment('合同签订日期');
    			$table->string('customer_name', 32)->default('')->comment('客户姓名');
    			$table->string('customer_mobile', 16)->default('')->comment('客户联系电话');
    			$table->string('bank', 128)->default('')->comment('开户行');
    			$table->string('bank_account', 128)->default('')->comment('利息支付账号');
    			$table->smallInteger('invest_amount')->unsigned()->default(0)->comment('投资期限(月)');
    			$table->integer('invest_money')->unsigned()->default(0)->comment('投资金额');
    			$table->integer('invest_earning')->unsigned()->default(0)->comment('投资收益');
    			$table->string('idCard_front', 128)->default('')->comment('身份证正面照');
    			$table->string('idCard_backend', 128)->default('')->comment('身份证反面照');
    			$table->timestamps();
    			$table->softDeletes();
    			 
    			$table->index('sign_time');
    			$table->index('manager_id');
    			$table->index('financial_user_id');
    			$table->index('serial_number');
    			$table->index('express_id');
    			$table->index('express_number');
    			$table->index(['express_send_time', 'express_arrive_time']);
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
    	Schema::connection('mysql_financial')->drop('financial_contract');
    }
}

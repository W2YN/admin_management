<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterPurifierTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_water_purifier')->create('water_purifier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('is_install')->default('0')->comment('是否安装');
            $table->timestamp('install_time')->comment('安装时间');
            $table->timestamp('booking_time')->comment('预约安装时间');
            $table->string('province','64')->comment('省份');
            $table->string('city','64')->comment('城市');
            $table->string('area','64')->comment('地区');
            $table->string('address','255')->comment('详细地址');
            $table->string('name','64')->comment('名字');
            $table->string('mobile','32')->comment('移动电话');
            $table->integer('sale_code')->comment('销售代码');
            $table->string('wx_openid','32')->comment('微信openID');
            $table->integer('status')->default('0')->comment('主状态(0;录入;1:扣首款;2:生效)');
            $table->integer('is_debit')->default('0')->comment('扣款状态(0;未扣款;1:已扣款)');
            $table->integer('is_complete')->default('0')->comment('填写状态(0;未填完;1:已填完)');
            $table->integer('payment_method')->default('0')->comment('付款方式(0;未指定;1:月付,2:半年付,3:年付)');
            $table->integer('payment_amount')->default('0')->comment('期数');
            $table->integer('payment_money')->default('0')->comment('总金额');
            $table->integer('payment_price')->default('0')->comment('单价');
            $table->integer('payment_deposit')->default('0')->comment('押金期数');
            $table->integer('card_id')->default('0')->comment('关联的银行卡ID');
            $table->integer('amount')->default('0')->comment('安装数量');
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
        Schema::connection('mysql_water_purifier')->drop('water_purifier');
    }
}

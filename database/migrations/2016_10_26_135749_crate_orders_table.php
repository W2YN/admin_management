<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num',64)->comment('订单号');
            $table->integer('business_money')->comment('商业险');
            $table->integer('force_money')->comment('交强险');
            $table->integer('travel_tax')->comment('车船税');
            $table->integer('amount')->comment('期数')->default('12');
            $table->string('car_owner',32)->comment('车主');
            $table->string('owner_mobile',32)->comment('车主手机号码');
            $table->integer('policy_type')->comment('保单类型(0:新客户;1:续保客户)')->default('0');
            $table->string('owner_id_number',32)->comment('车主身份证');
            $table->string('owner_province',64)->comment('省份');
            $table->string('owner_city',64)->comment('城市');
            $table->string('owner_area',64)->comment('地区');
            $table->string('owner_address')->comment('详细地址');
            $table->string('owner_postcode',6)->comment('邮编');
            $table->dateTime('policy_start_date')->comment('保险期间开始时间');
            $table->dateTime('policy_end_date')->comment('保险期间结束时间');
            $table->string('car_license_plate',32)->comment('车牌号码');
            $table->integer('car_type')->comment('机动车种类');
            $table->integer('car_use_property')->comment('使用性质');
            $table->integer('car_brand')->comment('车辆品牌');
            $table->string('car_model',32)->comment('车辆型号');
            $table->integer('car_plate_color')->comment('号牌颜色');
            $table->string('car_engine_num',32)->comment('发动机号码');
            $table->string('car_vin_code',32)->comment('车辆识别代码');
            $table->dateTime('car_register_date')->comment('注册日期');
            $table->dateTime('car_certificate_date')->comment('发证日期');
            $table->integer('car_rated_passenger')->comment('核定载客');
            $table->dateTime('car_Inspection_record')->comment('检验记录');
            $table->string('remark')->comment('备注');
            $table->string('driving_license_file')->comment('行驶证图片');
            $table->string('identity_card_file')->comment('身份证图片');
            $table->tinyInteger('status')->comment('状态(0:未处理;1:生效;2:支付;)');
            $table->dateTime('create_time')->comment('创建时间');
            $table->string('weixinOpenId')->comment('微信OpenID');
            $table->tinyInteger('is_delete')->comment('删除标志')->default('0');
            $table->string('ft',32)->comment('来源类型');
            $table->string('fid',32)->comment('来源id');

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
         Schema::connection('mysql_wx_official_accounts')->drop('orders');
    }
}


<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarInsuranceCreatePolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_car_insurance')->create('policy', function (Blueprint $table) {
            //
            $table->increments("id");
            $table->integer("order_id")->comment("订单id");
            $table->integer('compulsory_insurance')->comment('交强险');
            $table->integer('damage_insurance')->comment('机动车损失险');
            $table->integer('new_car_price')->comment('新车购置价');
            $table->integer('third_insurance')->comment('第三者责任险');
            $table->integer('third_insurance_money')->comment('第三者责任险价格');
            $table->integer('drivers_insurance')->comment('车上人员责任险(司机)');
            $table->integer('drivers_insurance_money')->comment('车上人员责任险(司机)价格');
            $table->integer('passenger_insurance')->comment('车上人员责任险（乘客）');
            $table->integer('passenger_insurance_money')->comment('车上人员责任险（乘客）价格');
            $table->integer('passenger_insurance_amount')->comment('车上人员责任险（乘客）座');
            $table->integer('theft_insurance')->comment('机动车盗抢险');
            $table->integer('glass_insurance')->comment('附加玻璃单独破碎险');
            $table->integer('selfcombustion_insurance')->comment('附加自燃损失险');
            $table->integer('engine_insurance')->comment("附加发动机损失险");
            $table->integer('nd_damage_insurance')->comment('不计免赔-机动车损失险');
            $table->integer('nd_third_insurance')->comment('不计免赔-第三者责任险');
            $table->integer('nd_drivers_insurance')->comment('不计免赔-车上人员责任险(司机)');
            $table->integer('nd_passenger_insurance')->comment('不计免赔-车上人员责任险(乘客)');
            $table->integer('nd_theft_insurance')->comment('不计免赔-机动车盗抢险');
            $table->integer('nd_engine_insurance')->comment('不计免赔-发动机损失险');

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
        Schema::connection('mysql_car_insurance')->drop('policy');
    }
}

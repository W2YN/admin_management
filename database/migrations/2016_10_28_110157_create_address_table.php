<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_wx_official_accounts')->create('wx_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("member_id")->comment("关联用户id");
            $table->string("receiver_name", 30)->comment("收货人姓名");
            $table->string("mobile", 11)->comment("收货人手机号");
            $table->string("area", 50)->comment("所在区");
            $table->string("city", 20)->comment("所在市");
            $table->string("province",20)->comment("所在省");
            $table->string('address_detail', 150)->comment("收货人详细地址");
            $table->integer("is_default")->comment("是否是默认地址");

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
        //
        Schema::connection('mysql_wx_official_accounts')->drop('wx_address');
    }
}

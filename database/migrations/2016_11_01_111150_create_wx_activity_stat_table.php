<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxActivityStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_wx_official_accounts')->create('wx_activity_stat', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('datetime')->comment('统计时间');
            $table->tinyInteger('type')->default(1)->comment('1、浏览人数,2、浏览量,3.分享次数,4、申请数量,5、订单量,6、成交用户,7、累计成交金额');
            $table->tinyInteger('actType')->default(1)->comment('1、净水器,2、车险分期');
            $table->decimal('count', 10, 2)->comment('统计数量');
            $table->string('param')->comment('访问地址');
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

        Schema::connection('mysql_wx_official_accounts')->drop('wx_activity_stat');
    }
}

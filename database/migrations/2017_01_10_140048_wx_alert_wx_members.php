<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class WxAlertWxMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_wx_official_accounts')->table('wx_members', function (Blueprint $table) {
            $table->tinyInteger('id_verify')->default(0)->comment('1：身份已校验 0：身份未校验');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_wx_official_accounts')->table('wx_members', function (Blueprint $table) {
            $table->dropColumn('id_verify');
            //
        });
    }
}

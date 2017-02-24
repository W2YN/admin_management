<?php
/**
 * Created by PhpStorm.
 * User: HONDA
 * Date: 2016/10/14
 * Time: 10:11
 */

use Illuminate\Database\Seeder;



class PrizeTableSeeder extends Seeder
{
    public function run()
    {
        \DB::connection("mysql_wx_official_accounts")->table('wx_prize')->delete();
        \DB::connection("mysql_wx_official_accounts")->table('wx_prize')->insert([
            0 => [
                'url' => '/static/personal-center/images/p3.png',
                'name'=> '100元油卡',
                'order' =>1,
                'medal_exchange_number' => 20,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'desc' => '100元超值油卡，赶紧兑换吧'
            ],
            1 => [
                'url' => '/static/personal-center/images/p2.jpg',
                'name'=> '制服比克大魔王的电饭锅',
                'order' =>2,
                'medal_exchange_number' => 20,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'desc' => '一切皆有可能，还不赶紧来试试'
            ],
            2 => [
                'url' => '/static/personal-center/images/p3.jpg',
                'name'=> 'Card',
                'order' =>3,
                'medal_exchange_number' => 20,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'desc' => '储存各种信息，没有你不能存储的'
            ]
        ]);
    }
}
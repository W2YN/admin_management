<?php

use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::connection("mysql_wx_official_accounts")->table('banks')->insert(
            array(
                0 =>
                    array(
                        'id' => 1,
                        'bank' => '招商银行',
                        'code' => 'B007',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'bank' => '工商银行',
                        'code' => 'B003',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'bank' => '农业银行',
                        'code' => 'B002',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'bank' => '光大银行',
                        'code' => 'null1',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'bank' => '邮政储蓄银行',
                        'code' => 'B006',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'bank' => '民生银行',
                        'code' => 'B008',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'bank' => '兴业银行',
                        'code' => 'B014',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'bank' => '深圳发展银行',
                        'code' => 'B013',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'bank' => '建设银行',
                        'code' => 'B004',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'bank' => '湖南信用社',
                        'code' => 'null2',
                        'from' => 'ldys',
                        'created_at' => '-0001-11-30 00:00:00',
                        'updated_at' => '-0001-11-30 00:00:00',
                    ),
            )
        );

    }
}

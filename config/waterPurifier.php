<?php

return [
    'local' => [
        'payment'=>[
            1   => [
                'price'    => 1,//每期单价
                'amount'   => 12,//分期次数
                'discount' => 1,//折扣
                'deposit'  => 1,//押金期数
                'interval'  => 30*24*60*60,//每期的支付间隔时间为30天'
            ],
            2   => [
                'price'    => 1,
                'amount'   => 2,
                'discount' => 1,
                'deposit'  => 0,
                'interval'  => 180*24*60*60,//每期的支付间隔时间为180天'
            ],
            3   => [
                'price'    => 1,
                'amount'   => 1,
                'discount' => 1,
                'deposit'  => 0,
                'interval'  => 360*24*60*60
            ],
        ],
        'banks'=>[
            'B007'=>'招商银行',
            'B003'=>'工商银行',
            'B002'=>'农业银行',
            'null1'=>'光大银行',
            'B006'=>'邮政储蓄银行',
            'B008'=>'民生银行',
            'B014'=>'兴业银行',
            'B013'=>'深圳发展银行',
            'B004'=>'建设银行',
            'null2'=>'湖南信用社',
        ],
        'maintain'=>[
            'interval' => 91*24*60*60,//每期的支付间隔时间为91天
            'amount' => 3, //一共进行3次维护
        ],
    ],
    'staging' => [
        'payment'=>[
            1   => [
                'price'    => 6000,
                'amount'   => 12,
                'discount' => 1,
                'deposit'  => 0,
                'interval'  => 30*24*60*60,//每期的支付间隔时间为30天'
            ],
            2   => [
                'price'    => 36000,
                'amount'   => 2,
                'discount' => 0.95,
                'deposit'  => 0,
                'interval'  => 180*24*60*60,//每期的支付间隔时间为180天'
            ],
            3   => [
                'price'    => 72000,
                'amount'   => 1,
                'discount' => 0.9,
                'deposit'  => 0,
                'interval'  => 360*24*60*60
            ],
        ],
        'banks'=>[
            1=>'工商银行',
            2=>'农业银行',
            3=>'光大银行',
            4=>'邮政储蓄银行',
            5=>'民生银行',
            6=>'兴业银行',
            7=>'深圳发展银行',
            8=>'建设银行',
            9=>'招商银行',
            10=>'湖南信用社',
        ],
        'maintain'=>[
            'interval' => 91*24*60*60,//每期的支付间隔时间为91天
            'amount' => 3, //一共进行3次维护
        ],
    ],
    'id_number_img'=>[
        'do_not_need'=>[//不需要提交身份证的来源类型
            'a',
            'yinlianshangwu',
            'zhongxiaoqiye'
        ]
    ],
    'main_title'=>[//特殊来源类型的特殊抬头
        'a'=>'特殊来源类型的特殊抬头',
        'yinlianshangwu'=>'',
        'zhongxiaoqiye'=>'浙江省中小企业公共服务平台'
    ]
];
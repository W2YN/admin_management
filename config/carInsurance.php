<?php
return [
    'status' => [
        'NULL' => '所有',
        //0 => '什么',
        1 => '未处理',
        2 => '处理中',
        3 => '等待支付信息',
        4 => '等待扣款',
        5 => '已生效',
    ],
    'policyType' => [
        '0' => '新客户',
        '1' => '续保客户',
    ],
    'carType' => [
        0 => "请选择",
        1 => '客车',
        2 => '货车',
        3 => '客货两用车',
        4 => '挂车',
        5 => '低速货车和三轮汽车',
        6 => '特种车',
        7 => '摩托车不含侧三轮',
        8 => '侧三轮',
        9 => '兼用型拖拉机',
        10 => '运输型拖拉机',
    ],

    'carUseProperty' => [
        0 => "请选择",
        1 => '家庭自用',
        2 => '非营业用不含家庭自用',
        3 => '出租\租赁',
        4 => '城市公交',
        5 => '公路客运',
        6 => '营业性货运',
    ],
    'carBrand' => [
        0 => "请选择",
        1 => '国产',
        2 => '进口',
        3 => '合资',
    ],
    'carPlateColor' => [
        0 => "请选择",
        1 => '蓝',
        2 => '黑',
        3 => '黄',
        4 => '白',
        5 => '白蓝',
        6 => '其他颜色',
    ],
    'insuranceType' => [
        1 => '商业险',
        2 => '强制险',
        3 => '车船税',
    ],
    'installmentStatus' => [
        0 => '未扣款',
        1 => '扣款中',
        2 => '已扣款'
    ],
    'test' => env('CAR_INSURANCE_TEST', false),
    'wxFrontAddress' => env('CAR_INSURANCE_DOMAIN', 'http://woa.local.jojin.com/carInsurance/file/show?path='),
    'installmentTest' => env('CAR_INSURANCE_INSTALLMENT_TEST', false),
    'pay' => [
        'createFreeze' => env('CAR_CREATE_FREEZE', "http://pay.local.jojin.com/api/v1/JieLan/PreFreeze"),
        'cancelFreeze' => env('CAR_CANCEL_FREEZE', "http://pay.local.jojin.com/api/v1/JieLan/PreFreezeCancel"),
        'charge' => env('CAR_CHARGE', "http://pay.local.jojin.com/api/v1/JieLan/RealtimeCharge")
    ],
    'projectNo' => env('CAR_PROJECT_NO', ''),
    'delay' => env('CAR_PAY_DELAY', 5),//默认5秒钟
    "store" => [
        "domain" => env("CAR_INSURANCE_STORE_DOMAIN", null),
        "basePath" => env('CAR_INSURANCE_STORE_BASEPATH', null),
        "subPath" => env('CAR_INSURANCE_STORE_SUBPATH', null),
    ]//,
    //'amount' => env('CAR_INSURANCE_AMOUNT', null)
];

<?php
return [
    'message' => [
        'template' => env('TEMPLATE_MSG', ''),
        'mobile' => env("MOBILE_MSG", ''),
    ],
    'projectNo'=> env('RBCX_PROJECT_NO', ''),
    'pay' => [
        'createFreeze' => env('RBCX_PRE_FREEZE',''),
        'charge' => env('RBCX_CHARGE'),
        'cancelFreeze' => env('RBCX_CANCEL_FREEZE', ''),
    ],
    'test' => env('RBCX_TEST', false),
    'installmentTest'=>env('RBCX_INSTALLMENT_TEST', false)
];
<?php
return [
    'models' => [
        'menu' => 'App\Models\Menu',
        'user' => 'App\Models\User',
        'role' => 'App\Models\Role',
        'action' => 'App\Models\Action',
        'permission' => 'App\Models\Permission',
        'freezeLog' => 'App\Models\FreezeLog',
        'waterSale' => 'App\Models\Water\Sale',
        'waterPurifier' => 'App\Models\Water\Purifier',
        'bankCard' => 'App\Models\Water\BankCard',
        'installment' => 'App\Models\Water\Installment',
        'device' => 'App\Models\Water\Device',
        'maintain' => 'App\Models\Water\Maintain',
		'channel' => 'App\Models\Water\Channel',
        'actionLogger' => 'App\Models\ActionLogger',
        'message' => 'App\Models\Message',
        'contract' => [
            'contract' => 'App\Models\Contract\Contract',
            'contractInstallment' => 'App\Models\Contract\ContractInstallment'
        ],
        'carInsurance' => [
            'order' => 'App\Models\CarInsurance\Order'
        ],
        'rbcx' => [
            'order' => 'App\Models\Rbcx\Order',
            'cardinfo' => 'App\Models\Rbcx\CardInfo'
        ],
        'wxActivityStat' => 'App\Models\WxActivityStat',
        'sms' => [
            'sms' => 'App\Models\Sms\Sms'

        ],
        'wxplatform' => [
            'message' => 'App\Models\Wxplat\Message',
            'event' => 'App\Models\Wxplat\Event',
            'user' => 'App\Models\Wxplat\WxUser',
            'notice' => 'App\Models\Wxplat\WxNotice',
            'template' => 'App\Models\Wxplat\WxTemplate',
            'templatemessage' => 'App\Models\Wxplat\WxTemplateMessage',
            'menu' => 'App\Models\Wxplat\WxMenu',
        ],
        'financial' => [
	        'contract' => 'App\Models\Financial\Contract',
	        'express' => 'App\Models\Financial\Express',
	        'user' => 'App\Models\Financial\User',
        ],
        
    ],
    'page-limit' => 20,
];

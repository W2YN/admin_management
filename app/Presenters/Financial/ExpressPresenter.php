<?php

namespace App\Presenters\Financial;

use App\Traits\Presenter\BasePresenterTrait;

class ExpressPresenter
{
    use BasePresenterTrait;

    public function getSearchParams()
    {
    	$express_config['NULL'] = '全部快递公司';
    	$express_config = $express_config + config('financial.express');

	    return [
	        'route' => 'backend.financial.express',
	        'inputs' => [
	            [
	                'type' => 'select',
	                'name' => 'eq-status',
	                'options' => ['NULL' => '全部状态', '1' => '邮寄中', '2' => '已收取'],
	                'class' => 'select'
	            ],
	            [
	                'type' => 'select',
	                'name' => 'eq-express_company_id',
	                'options' => $express_config,
	                'class' => 'select'
	            ],
	            [
	                'type' => 'text',
	                'name' => 'eq-number',
	                'placeholder' => '快递单号',
	                'class' => 'input-text Wdate'
	            ],
	            [
	                'type' => 'date',
	                'name' => 'datetime',
	                'placeholder' => '发送日期'
	            ],
            ],
	    ];
    }

    public function getHandleParams()
    {
    	return [
            [
	            'title' => '发送快递',
	            'click' => 'frame_window_open_full("发送快递","' . route('backend.financial.express.create') . '")',
	            'icon' => '',
            ],
    	];
    }
    
    public function getTableParams()
    {
    	return [
	        'title' => '合同快递列表',
	        'fields' => [
	            'id' => '编号',
	            'number' => '快递单号',
	            'express_company_id' => [
	                                     '快递公司', 
	                                     function ($express_company_id){
	                                     	return $this->formatCompany($express_company_id);
	                                     }
                                        ],
	            'manager_name' => '发送者名称',
	            'name' => '接收者名称',
	            'num' => '合同份数',
	            'status' => [
	                         '快递状态',
	                         function ($status){
    		                     return $this->formatStatus($status);
    	                     }  
                            ],
	            'send_time' => '发送时间',
	            'arrive_time' => '到达时间',
    	    ],
    	    'handleWidth' => '200px',
    	    'handle' => [
    	        [
    	            'type' => 'admin_tab',
    	            'title' => '快递详情',
    	            'text' => '快递详情',
    	            'route' => 'backend.financial.express.show',
    	        ],
    	    ],
    	];
    }
    
    public function formatCompany($express_company_id)
    {
    	$all_company = config('financial.express');
    	foreach ($all_company as $key => $val){
    		if ($key == $express_company_id){
    			return $val;
    		}
    	}
    }
    
    public function formatStatus($status)
    {
    	if ($status == 1){
    		return '邮寄中';
    	}else{
    		return '已收取';
    	}
    }
}







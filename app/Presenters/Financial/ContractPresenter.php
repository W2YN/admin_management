<?php

namespace App\Presenters\Financial;

use App\Traits\Presenter\BasePresenterTrait;

class ContractPresenter
{
	use BasePresenterTrait;
	
	public function getSearchParams()
	{
		$contract_config['NULL'] = '全部类型';
		$contract_config = $contract_config + config('financial.contract');
	
		$contract_status_config['NULL'] = '全部状态';
		$contract_status_config = $contract_status_config + config('financial.contract_status');
		
		return [
		    'route' => 'backend.financial.contract',
		    'inputs' => [
		        [
		            'type' => 'text',
		            'name' => 'eq-serial_number',
		            'placeholder' => '合同编号',
		            'class' => 'input-text Wdate'
		    	],
		        [
		            'type' => 'select',
		            'name' => 'eq-type_id',
		            'options' => $contract_config,
		            'class' => 'select'
				],
				[
				    'type' => 'select',
				    'name' => 'eq-status',
				    'options' => $contract_status_config,
				    'class' => 'select'
				],
				[
				    'type' => 'date',
				    'name' => 'datetime',
				    'placeholder' => '签订日期'
				],
             ],
	    ];
	}
	
	public function getHandleParams()
	{
		return [];
	}
	
	public function getTableParams()
	{
		return [
		    'title' => '合同列表',
		    'fields' => [
		        'id' => '编号',
		        'serial_number' => '合同编号',
		        'type_id' => ['合同类型', function ($type_id){return $this->formatType($type_id);}],
		        'manager_name' => '建立合同人',
		        'name' => '合同接收人',
		        'number' => '快递单号',
		        'send_time' => '快递发送时间',
		        'status' => ['合同状态', function ($status){return $this->formatStatus($status);}],
		        'sign_time' => '签订日期',
		    ],
		    'handleWidth' => '160px',
		    'handle' => [
		        [
		            'type' => 'admin_tab',
		            'title' => '合同详情',
		            'text' => '合同详情',
		            'route' => 'backend.financial.contract.show',
		        ],
		        [
		            'type' => 'click',
		            'text' => '回邮已收到',
		            'click' => 'set_express_back(this)',
		        ],
		        [
		            'type' => 'click',
		            'text' => '设为存档',
		            'click' => 'set_keep_in_the_archives(this)',
		        ],
		    ],
		];
	}
	
	public function formatType($type_id)
	{
		$all = config('financial.contract');
		foreach ($all as $key => $val) {
			if ($key == $type_id) {
				return $val;
			}
		}
	}

	public function formatStatus($status)
	{
		$all = config('financial.contract_status');
		foreach ($all as $key => $val) {
			if ($key == $status) {
				return $val;
			}
		}
	}
	
	public function formatExceptionStatus($status)
	{
		$all = config('financial.contract_exception_status');
		foreach ($all as $key => $val) {
			if ($key == $status) {
				return $val;
			}
		}
	}
	
}




























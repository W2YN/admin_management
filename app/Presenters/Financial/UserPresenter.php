<?php

namespace App\Presenters\Financial;

use App\Traits\Presenter\BasePresenterTrait;

class UserPresenter
{
	use BasePresenterTrait;
	
	public function getSearchParams()
	{
		return [
	        'route' => 'backend.financial.user',
	        'inputs' => [
	            [
	                'type' => 'text',
	                'name' => 'eq-mobile',
	                'placeholder' => '手机号',
	                'class' => 'input-text Wdate'
	            ],
		    ],
		];
	}
	
	public function getHandleParams()
	{
		return [
		];
	}
	
	public function getTableParams()
	{
		return [
		    'title' => '金融用户列表',
		    'fields' => [
		        'id' => '编号',
		        'name' => '名称',
			    'email' => 'email',
		        'mobile' => '手机号',
		    ],
		    'handleWidth' => '200px',
		    'handle' => [],
		];
	}
	
}
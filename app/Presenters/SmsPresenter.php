<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;

/**
 * Menu View Presenters
 */
class SmsPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */
    public function showDisplayFormat($status)
    {
    	$ret_val = '';
    	
    	switch($status){
    		case 0:
    			$ret_val = '未发送';
    			break;
    		case 1:
    			$ret_val = '发送中';
    			break;
    		case 2:
    			$ret_val = '已发送';
    			break;
    		case 3:
    			$ret_val = '发送失败';
    			break;
    		default:
    			$ret_val = '未知状态';
    			break;
    	}
    	
    	return $ret_val;
    }

    public function getSearchParams()
    {
        return [
            'route'  => 'backend.sms.index',
            'inputs' => [
                [
                    'type'        => 'text',
                    'name'        => 'mobiles',
                    'placeholder' => '手机号',
                    'class'       => 'input-text Wdate'
                ],
            ],
        ];
    }

    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.menu.create',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '发送短信',
                'click' => "frame_window_open('发送','".route('backend.menu.create')."','800')"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title'  => '短信管理',
            'fields' => [
                'id' => '短信编号',
                'user_id' => '用户ID',
                'mobiles' => '手机号',
                'content'  => '短信内容',
                'opertion_time' => '发送时间',
                'status' => ['短信状态', function($status){return $this->showDisplayFormat($status);}],
                'id' => '短信编号',
                'channel' => '发送通道',
                'error_count' => '失败次数',
            ],
            'fieldWidth'=>[
            	'content' => '300px',
            ],
            'handle' => [
	            [
		            'type'  => 'delete',
		            'title' => '删除',
		            'route' => 'backend.sms.destory',
	            ],
			],
        	'handleWidth' => '120px',
        ];
    }
}

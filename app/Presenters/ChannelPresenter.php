<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;

class ChannelPresenter
{
	use  BasePresenterTrait;
	
	public function getSearchParams()
	{
		return [
			'route'  => 'backend.channel.index',
			'inputs' => [
				[
					'type'        => 'text',
					'name'        => 'username',
					'placeholder' => '用户名',
					'class'       => 'input-text Wdate'
				],
				[
					'type'        => 'text',
					'name'        => 'from_type',
					'placeholder' => '来源类型',
					'class'       => 'input-text Wdate'
				],
				[
					'type'        => 'date',
					'name'        => 'created_at',
					'placeholder' => '创建时间',
					'class'       => 'input-text Wdate'
				],
			],
		];
	}
	
	public function getHandleParams()
	{
		return [
			[
				'route' => 'backend.channel.create',
				'icon'  => '&#xe600;',
				'class' => 'success',
				'title' => '新增渠道',
				'click' => "frame_window_open('新增渠道','".route('backend.channel.create')."','800')"
			],
		];
	}
	
	public function getTableParams()
	{
		return [
			'title'  => '渠道列表',
			'fields' => [
				'id'    => '编号',
				'username' => '用户名',
				'from_type' => '来源类型',
				'created_at' => '创建时间',
			],
			'handleWidth'=>'120px',
			'handle' => [
				[
					'type'  => 'click',
					'text'  => '渠道详情',
					'route' => 'backend.channel.show',
					'click' => 'show("/backend/channel/show", this)',
				],
				[
					'type'  => 'edit',
					'title' => '渠道编辑',
					'text'  => '渠道编辑',
					'route' => 'backend.channel.edit',
					'width' => 800,
					'height' => 400,
				],
				[
                	'type'  => 'delete',
                	'title' => '删除',
                	'route' => 'backend.channel.destroy',
            	],
			],
		];
	}
}





















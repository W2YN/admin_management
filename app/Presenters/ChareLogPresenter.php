<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/8
 * Time: 13:59
 */

namespace App\Presenters;


use App\Traits\Presenter\BasePresenterTrait;




class ChareLogPresenter extends CommonPresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route'  => 'backend.rbcx.charge.log',
            'inputs' => [
//                [
//                    'type'    => 'select',
//                    'name'    => 'type',
//                    'options' => array(0=>'生成',1=>'完成',2=>'撤销',3=>'实时扣款'),
//                    'class'   => 'select'
//                ],
                [
                    'type'        => 'text',
                    'name'        => 'car_owner',
                    'placeholder' => '车主',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'license_plate',
                    'placeholder' => '车牌',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'datetime',
                ],
            ],
        ];
    }


    public function getHandleParams()
    {
        return [
//            [
//                'route' => 'backend.vlan.create',
//                'icon'  => '&#xe600;',
//                'class' => 'success',
//                'title' => '新增VLan',
//                'click' => "frame_window_open('新增VLan','".route('backend.vlan.create')."','400','400')"
//            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title'  => '扣款记录',
            'fields' => [
                'id'    => '编号',
                'order_no'  => '订单号',
                'car_owner'    => '车主',
                'license_plate'    => '车牌号码',
                'installment_id'    => '分期编号',
                'money'  => '金额(分)',
                'datetime'  => '扣款日期',
                'retCode'  => '返回码',
                'queryId'  => '平台返回流水号',
                'processDate'  => '系统处理日期',
            ],
            'fieldWidth'=>[
                'disable'    => '30px',
                'id'    => '30px',
            ],
            'handleWidth'=>'120px',
            'handle' => [
//                [
//                    'type'  => 'edit',
//                    'title' => '编辑VLan',
//                    'route' => 'backend.vlan.edit',
//                    'width' => 400,
//                    'height'    => 400,
//                ],
//                [
//                    'type'  => 'delete',
//                    'title' => '删除',
//                    'route' => 'backend.vlan.destroy',
//                ],
            ],
        ];
    }
}
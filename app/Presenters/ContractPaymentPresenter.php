<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 16:51
 */

namespace App\Presenters;


use App\Traits\Presenter\BasePresenterTrait;
use NumberFormatter;

class ContractPaymentPresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route'  => 'backend.contract.payment',
            'inputs' => [
                [
                    'type'        => 'text',
                    'name'        => 'id',
                    'placeholder' => '编号',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'contract_id',
                    'placeholder' => '合同编号',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'number',
                    'placeholder' => '合同编码',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type' => 'select',
                    'name' => 'status',
                    'class' => 'input-text',
                    'options' => [
                        'NULL' => '所有状态',
                        //0 => '什么',
                        1 => '未支付',
                        2 => '已支付',
                    ],
                ],
                [
                    'type' => 'select',
                    'name' => 'type',
                    'class' => 'input-text',
                    'options' => [
                        'NULL' => '所有种类',
                        //0 => '什么',
                        0 => '利息',
                         1=> '本金',
                    ],
                ],
                [
                    'type' => 'date',
                    'name' => 'opertion_time',
                    'placeholder' => '支付时间',
                ],
            ],
        ];
    }


    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.contract.payment',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '导出Excel',
                'click' => "contractExport('".route('backend.contract.export')."')"
            ],
            [
                'route' => 'backend.contract.payment',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '导出批量汇款文档',
                'click' => "contractExport('".route('backend.contract.exportRemittance')."')"
            ],
            [
                'route' => 'backend.contract.capitalBills',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '导出还本明细单',
                'click' => "contractExport('".route('backend.contract.capitalBills')."')"
            ],
            [
                'route' => 'backend.contract.interestBills',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '导出利息支付明细单',
                'click' => "contractExport('".route('backend.contract.interestBills')."')"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title'  => '业务员列表',
            'fields' => [
                'id'    => '编号',
                'contract_id'  => '合同编号',
                'name' => '借款人',
                'number'=>'合同编码',
                'opertion_time'  => '支付时间',
                'money'  => ['支付金额', function($value){return $this->formatAmount($value);}],
                'status'  => ['状态', function($value){return $this->formatStatus($value);}],
                'type'  => ['类型', function($value){return self::formatType($value);}],
                'remark'  => '备注',
            ],
            'fieldWidth'=>[
                'id'    => '30px',
            ],
            'handleWidth'=>'120px',
            'handle' => [
                [
                    'type'  => 'click',
                    'text' => '设为已付',
                    'click' =>  "payPost(this,'".route('backend.contract.payed',['id'=>'id'])."')",
                ],
            ],
        ];
    }

    public function formatAmount($value)
    {
        return number_format($value/100, 2) . '元';
    }

    public static function formatType($value)
    {
        switch($value){
            case 0:
                return "利息";
            case 1:
                return "本金";
            default:
                return '未知';
        }

    }

    public function formatStatus($value)
    {
        switch($value){
            case 1:
                return "未支付";
            case 2:
                return "已支付";
            default:
                return '未知';
        }

    }
}
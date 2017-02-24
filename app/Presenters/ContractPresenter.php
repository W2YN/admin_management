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

class ContractPresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route'  => 'backend.contract.index',
            'inputs' => [
                [
                    'type'        => 'text',
                    'name'        => 'id',
                    'placeholder' => '编号',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'name',
                    'placeholder' => '姓名',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'number',
                    'placeholder' => '合同编码',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'    => 'select',
                    'name'    => 'is_confirm',
                    'options' => ['NULL'=>'所有',"1"=>'已确认',"0"=>'未确认'],
                    'class'   => 'select',
                    'placeholder' => '确认：',
                ],
                [
                    'type' => 'date',
                    'name' => 'buy_date',
                    'placeholder' => '购买日期',
                ],
            ],
        ];
    }


    public function getHandleParams()
    {
        return [
//            [
//                'route' => 'backend.contract.create',
//                'icon'  => '&#xe600;',
//                'class' => 'success',
//                'title' => '新增合同',
//                'click' => "frame_window_open_full('新增合同','".route('backend.contract.create')."')"
//            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title'  => '业务员列表',
            'fields' => [
                'id'    => '编号',
                'name'  => '姓名',
                'number'  => '合同编码',
                'amount'  => ['金额', function($value){return $this->formatAmount($value);}],
                'count'  => '期数',
                'interest'  => ['年化利率', function($value){return $this->formatInterest($value);}],
                'buy_date'  => '购买日期',
                'source'  => ['来源', function($value){return $this->formatSource($value);}],
                'expiry_date'  => '到期日期',
                'is_confirm'  => ['确认', function($value){return $this->formatIsConfirm($value);}],
            ],
            'fieldWidth'=>[
                'id'    => '30px',
            ],
            'handleWidth'=>'140px',
            'handle' => [
                [
                    'type'  => 'show',
                    'title' => '合同详情',
                    'text'  => '详情',
                    'route' => 'backend.contract.show',

                ],
                [
                    'type'  => 'edit',
                    'title' => '编辑',
                    'route' => 'backend.contract.edit',
                    'width' => 800,
                    'height' => 700,
                ],
                [
                    'type'  => 'click',
                    'text'  => '确认函',
                    'click' => "openUrl(this,'".route('backend.contract.confirmation',['id'=>'id'])."')",
                ],
                [
                    'type'  => 'click',
                    'text' => '收据',
                    'click' =>  "openUrl(this,'".route('backend.contract.receipt',['id'=>'id'])."')",
                ],
            ],
        ];
    }

    public function formatAmount($value)
    {
        return number_format($value/100, 2) . '元';
    }


    public function formatIsConfirm($value)
    {
        switch($value){
            case 0:
                return "未确认";
            case 1:
                return "已确认";
            default:
                return '未知';
        }

    }

    public function formatSource($value)
    {
        $config = config('contract.sourceOptions');
        return $config[$value];
    }

    public function formatInterest($value)
    {
        $config = config('contract.interestOptions');
        return $config[$value];
    }

    public function formatBankCode($bankCode)
    {
        $config = config('contract.bankCodes');
        return $config[$bankCode];
    }

    public function formatBankType($bankType)
    {
        $config = config('contract.bankTypes');
        return $config[$bankType];
    }


    public function getDimensionCountSearchParams()
    {
        return [
            'route'  => 'backend.contract.dimensionCount',
            'inputs' => [
                /*[
                    'type'        => 'text',
                    'name'        => 'id',
                    'placeholder' => '编号',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'name',
                    'placeholder' => '姓名',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'number',
                    'placeholder' => '合同编码',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'    => 'select',
                    'name'    => 'is_confirm',
                    'options' => ['NULL'=>'所有',"1"=>'已确认',"0"=>'未确认'],
                    'class'   => 'select',
                    'placeholder' => '确认：',
                ],*/
                /*[
                    'type' => 'select',
                    'name' => 'opertion_time',
                    'placeholder' => '支付时间',
                    'class' => 'select',
                    'options' => ['NULL'=>'所有', "1"=>'未支付', "2"=>'已支付']
                ],*/
                [
                    'type' => 'date',
                    'name' => 'opertion_time',
                    'placeholder' => '支付时间',
                ],
               /* [
                    'type' => 'select',
                    'name' => 'status',
                    'placeholder' => '状态',
                    'class' => 'select',
                    'options' => ['NULL'=>'所有', "1"=>'未支付', "2"=>'已支付']
                ],
                [
                    'type' => 'select',
                    'name' => 'type',
                    'placeholder' => '类型',
                    'class' => 'select',
                    'options' => ['NULL'=>'所有', "1"=>'利息', "2"=>'本金']
                ]*/
            ],
        ];
    }

    public function formatChecked($in)
    {
        return "¥".number_format($in/100, 2) ;
    }

    public function getStudyTableParams()
    {
        return [
            'pageId' => 'installment',
            'title' => '业务员列表',
            'fields' => [
                'type' => '类型',
                'checked' => '已支付(元)',
                'unchecked' => '未支付(元)',
                'total' => '总共(元)',
                'between' => '时间段'
            ],

            'fieldWidth' => [
                'type' => '60px',
            ],
            'handleWidth' => '120px',

        ];
    }

}
<?php

namespace App\Presenters;

use App\Models\Rbcx\Installment;
use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class RbcxOrderPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */

    public function formatAmount($value)
    {
        return number_format($value/100, 2) . '元';
    }



    public function showStatus($status)
    {
        if ($status == 1) {
            return "未扣款";
        }
        if ($status == 2){
            return "已扣款,未出保单";
        }
        if ($status == 3){
            return "已出保单";
        }
        else {
            return "未知";
        }
//    else {
  //          return "已出保单";
    //    }
    }
    public function showType($type)
    {
        if ($type == 1) {
            return "商业险";
        }
        if ($type == 2){
            return "强制险";
        }
        if($type == 4) {
            return "总额分期";
        }
        else {
            return "车船税";
        }
    }
    public function showFirstCharge($charge)
    {
        if ($charge == 0) {
            return "未扣";
        }
        if ($charge == 1){
            return "已扣";
        }

    }

    public function showSignature($signature)
    {
        if ($signature == 0) {
            return "未签";
        }
        if ($signature == 1){
            return "已签";
        }

    }

    public function showEnable($enable)
    {
        if ($enable == 0) {
            return "未激活";
        }
        if ($enable == 1){
            return "已激活";
        }

    }


    public function getSearchParams()
    {
        return [
            'route' => 'backend.rbcx.index',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'car_owner',
                    'placeholder' => '车主',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'mobile',
                    'placeholder' => '手机号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type'    => 'select',
                    'name'    => 'status',
                    'options' => [''=>'请选择',"1"=>'未扣款',"2"=>'已扣款','3'=>'已出保单'],
                    'class'   => 'select',
                    'placeholder' => '状态：',
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
            'title' => '订单管理',
            'fields' => [
                'id' => 'id',
                'num' => '订单号',
                'car_owner' => '车主',
                'mobile' => '手机号',
                'license_plate' => '车牌号码',
                'datetime' => '创建时间',
                'status'=>['状态', function($value){return $this->showStatus($value);}],
                'first_charge'=>['首次扣款', function($value){return $this->showFirstCharge($value);}],
                'is_signature'=>['签名', function($value){return $this->showSignature($value);}],
                'enable'=>['是否激活', function($value){return $this->showEnable($value);}],

            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.rbcx.show',

                ],
//                [
//                    'type'  => 'edit',
//                    'title' => '编辑',
//                    'route' => 'backend.contract.edit',
//                    'width' => 800,
//                    'height' => 700,
//                ],
//                [
//                    'type'  => 'click',
//                    'text'  => '确认函',
//                    'click' => "openUrl(this,'".route('backend.contract.confirmation',['id'=>'id'])."')",
//                ],
//                [
//                    'type'  => 'click',
//                    'text' => '收据',
//                    'click' =>  "openUrl(this,'".route('backend.contract.receipt',['id'=>'id'])."')",
//                ],
            ],
        ];
    }

    public function getSignatureCheckTableParams()
    {
        return [
            'title' => '订单管理',
            'fields' => [
                'id' => 'id',
                'num' => '订单号',
                'car_owner' => '车主',
                'mobile' => '手机号',
                'license_plate' => '车牌号码',
                'status'=>['状态', function($value){return $this->showStatus($value);}],
                'first_charge'=>['首次扣款', function($value){return $this->showFirstCharge($value);}],
                'is_signature'=>['签名', function($value){return $this->showSignature($value);}],
                'enable'=>['是否激活', function($value){return $this->showEnable($value);}],

            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.rbcx.show',

                ],
            ],
        ];
    }


    public function formatInstallmentStatus($in)
    {
        switch ((int)$in) {
            case 0:
                return "未扣款";
            case 1:
                return "扣款中";
            case 2:
                return "已扣款";
        }
    }

    public function getFreezeLogTableParams()
    {
        return [
            'title' => '订单管理',
            'fields' => [
                'id' => 'id',
               // 'order_id' => '保单号',
                'order_no' => '支付请求订单号',
                'installment_id' => '分期ID',
                'type' => ['扣款类型', function($in) { return $this->formatFreezeType($in);}],
                'orderStatus'=>['状态', function($value){return $this->formatFreezeLogOrderStatus($value);}],
                'retDesc' => '订单描述',
                'queryId' => '平台流水号',
                'processDate' => '系统处理时间'

            ],
            'handleWidth' => '140px',

        ];
    }

    public function formatFreezeType($in)
    {
        switch ($in) {
            case 0:
                return "预冻结生成";
            case 1:
                return "预冻结完成";
            case 2:
                return "预冻结撤销";
            case 3:
                return "实时扣款";
        }
    }

    function formatFreezeLogOrderStatus($in)
    {
        switch ($in) {
            case 0:
                return "已接受";
            case 1:
                return "处理中";
            case 2:
                return "已完成";
            case 3:
                return '失败';
        }
    }

    public function getFreezeTableParams()
    {
        return [
            'pageId' => 'freeze',
            'title' => '预冻结表',
            'fields' => [
                'id' => 'id',
                'order_id' => '订单id',
                'money' => ['冻结金额(元)', function($in) {return $this->formatFreezeMoney($in);}],
                'freeze_queryid' => '冻结流水号',

                'datetime' => '冻结时间',
               // 'created_at' => '创建时间',
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',

        ];
    }

    public function formatFreezeMoney($in)
    {
        return $in/100;
    }

    /**
     * 一个分期有可能的操作
     * @param Installment $installment
     */
    public function showAction(Installment $installment)
    {
        if(strtotime($installment->opertiontime) < time()){//大前提
            if($installment->status != 2 or $installment->money > $installment->debit_money) {
                $installmentId = $installment->id;
                return "<a href='javascript:void(0)' class='btn btn-default' onclick='chargeExpired($installmentId)'>扣款</a>";
            }
        }
        return "<span>无需操作</span>";
        /*if($installment->status !=2 and strtotime($installment->opertiontime) < time() and $installment->money > $installment->debit_money) { //这是需要扣款的，但是并没有扣款

        }else {
            return "<span>无需操作</span>";
        }*/
    }
}

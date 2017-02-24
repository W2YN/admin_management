<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 16:51
 */

namespace App\Presenters;


use App\Traits\Presenter\BasePresenterTrait;

class CarInsuranceOrderPresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route' => 'backend.carInsurance.order.index',
            'inputs' => [
                [
                    'type' => 'select',
                    'name' => 'status',
                    'class' => 'input-text',
                    'options' => config('carInsurance.status'),
                ],
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                //要不要去了?
                [
                    'type' => 'text',
                    'name' => 'ft',
                    'placeholder' => '客户来源',
                    'class' => 'input-text Wdate'
                ],
                //要不要去了?
                [
                    'type' => 'text',
                    'name' => 'policy_type',
                    'placeholder' => '保单类型',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'car_license_plate',
                    'placeholder' => '车牌号',
                    'class' => 'input-text Wdate',
                ],
                [
                    'type' => 'text',
                    'name' => 'recommend_name',
                    'placeholder' => '推荐人ID',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'created_at',
                    'placeholder' => '创建时间',
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

    function formatAmount_($in)
    {
        return $in . "期";
    }

    function formatStatus($in)
    {
        switch ($in) {
            //case 0:
            case 1:
                return '未处理';
            case 2:
                return '处理中';
            case 3:
                return "等待支付信息";
            case 4:
                return "等待扣款";
            case 5:
                return "已生效";
        }
    }

    public function getPendingOrderTableParams()
    {
        return [
            'title' => '业务员列表',
            'fields' => [
                'num' => '订单',
                'car_owner' => '车主',
                'car_license_plate' => '车牌',
                'amount' => ['期数', function ($in) {
                    return $this->formatAmount_($in);
                }],
                'policy_type' => '保单类型',
                'ft' => '来源类型',
                'status' => ['状态', function($in){return $this->formatStatus($in);}],
                'created_at' => '创建于'
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.carInsurance.order.show',
                ]
            ],
        ];
    }

    /**
     * 通过当前用户Model获取指定的RouteEdit
     */
    public function getSuitableEditAction()
    {

    }

    /**
     * 需要注入一个role来判断edit的路由选择
     * @return array
     */
    public function getTableParams()
    {
        return [
            'title' => '业务员列表',
            'fields' => [
                'num' => '订单',
                'car_owner' => '车主',
                'car_license_plate' => '车牌',
                //'amount' => ['期数', function($in){return $this->formatAmount_($in);}],
                // 'policy_type' => '保单类型',
                'ft' => '来源类型',
                'user_name' => '所属销售',
                'created_at' => '创建时间',
                'status' => ['状态', function ($in) {
                    return $this->formatStatus($in);
                }],

            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.carInsurance.order.show',

                ],
                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'route' => 'backend.carInsurance.order.edit',
                    'width' => 800,
                    'height' => 700,
                ],
                /*[
                    'type' => 'delete',
                    'title' => '删除',
                    'route' => 'backend.carInsurance.order.destroy',
                    'width' => 800,
                    'height' => 700,
                ],*/
                [
                    'type' => 'download',
                    'title' => '下载',
                    'route' => 'backend.carInsurance.order.download',
                ]
            ],
        ];
    }


    public function getCardInfoTableParams()
    {
        return [
            'pageId' => 'cardInfo',
            'title' => '业务员列表',
            'fields' => [
                'name' => '持卡人',
                'card' => '卡号',
                'phone_number' => '预留手机号码',
                'id_number' => '持卡人身份证信息',
//                'cvn_number'=>'CVN安全码',
//                'card_validity'=>'信用卡有效期',
                'last_check' => '最后一次有效性',
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',

        ];
    }

    public function getInstallmentTableParams()
    {
        return [
            'pageId' => 'installment',
            'title' => '业务员列表',
            'fields' => [
                'id' => 'id',
                'type' => '类型',
                'money' => ['扣款金额', function($in) {return $this->formatAmount($in);}],
                'debit_money' => ['已扣金额', function($in) {return $this->formatAmount($in);}],

                'error_count' => '失败次数',
                'remark' => '备注',
                'opertiontime' => '扣款时间',
                'created_at' => '创建时间',
                'status' => '状态',
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',

        ];
    }

    public function formatAmount($value)
    {
        return number_format($value / 100, 2) . '元';
    }


    /**
     * 获取分期信息需要的搜索参数
     */
    public function getInstallmentSearchParams()
    {
        return [
            'route' => 'backend.carInsurance.installments',
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
                    'placeholder' => '名字',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'owner_mobile',
                    'placeholder' => '移动电话',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'opertiontime',
                    'placeholder' => '扣款时间',
                    'class' => 'input-text Wdate'
                ]
                /*[
                    'type'        => 'date',
                    'name'        => 'opertion_time',
                    'placeholder' => '结束扣款时间',
                    'class'       => 'input-text Wdate'
                ],*/
            ],
        ];
    }

    /**
     * 获取分期信息表参数信息
     */
    public function getInstallmentDetailTableParams()
    {
        return [
            'title' => '净水器订单',
            'fields' => [
                'id' => '编号',
                'num' => '订单号',
                'car_owner' => '名字',
                'owner_mobile' => '移动电话',
                'opertiontime' => '扣款时间',
//                'province'  => '省份',
//                'city'  => '城市',
//                'area'  => '地区',
                'money' => '扣款金额',
                'debit_money' => '已扣金额',
                'error_count' => '扣款失败次数',
                'status' => ['状态', function ($value) {
                    return config('carInsurance.installmentStatus.' . $value, '异常');
                }],
                'remark' => '备注'
                //'status' => '主状态(0;录入;1:扣首款;2:生效)',
                //'is_debit' => '扣款状态(0;未扣款;1:已扣款)',
                //'is_complete' => '填写状态(0;未填完;1:已填完)',
            ],
            'handleWidth' => '130px',
            'handle' => [
//                [
//                    'type'  => 'delete',
//                    'title' => '删除',
//                    'route' => 'backend.waterPurifier.destroy',
//                ],
                [
                    'type' => 'other', //不展示的意思
                    'title' => '净水器:订单详情',
                    'text' => '订单详情',
                    'route' => 'backend.waterPurifier.show',

                ],
            ]
        ];
    }

    public function getPendingOrderSearchParams()
    {
        return [
            'route' => 'backend.carInsurance.order.pendingOrder',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'ft',
                    'placeholder' => '客户来源',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'policy_type',
                    'placeholder' => '保单类型',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'recommend_name',
                    'placeholder' => '推荐人',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'created_at',
                    'placeholder' => '创建时间',
                ],
            ],
        ];
    }


    public function getMyOrderSearchParams()
    {
        return [
            'route' => 'backend.carInsurance.order.myOrder',
            'inputs' => [
                [
                    'type' => 'select',
                    'name' => 'eq-status',
                    'placeholder' => '状态：',
                    'class' => 'input-text Wdate',
                    'options' => config('carInsurance.status'),
                ],
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'ft',
                    'placeholder' => '客户来源',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'policy_type',
                    'placeholder' => '保单类型',
                    'class' => 'input-text Wdate'
                ],

                [
                    'type' => 'date',
                    'name' => 'created_at',
                    'placeholder' => '创建时间',
                ],
            ],
        ];
    }

    public function getPaymentLogTableParams()
    {
        return [
            'pageId' => 'paymentLog',
            'title' => '业务员列表',
            'fields' => [
                //'id' => 'id',
                //'order_id' => '订单id',
                'order_num' => '支付请求订单号',
                'installment_id' => ['分期ID', function ($in) {
                    return $in == 0 ? "" : $in;
                }],

                'status' => ['扣款类型', function ($in) {
                    return $this->formatPayLogStatus($in);
                }],
                'orderStatus' => ['状态', function ($in) {
                    return $this->formatPayLogOrderStatus($in);
                }],
                'retDesc' => '订单描述',
                'queryId' => '平台流水号',
                'processTime' => '系统处理时间',
                'created_at' => '创建时间',
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',

        ];
    }

    function formatPayLogStatus($in)
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

    function formatPayLogOrderStatus($in)
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

    function getFreezeTableParams()
    {
        return [
            'pageId' => 'freeze',
            'title' => '预冻结表',
            'fields' => [
                'id' => 'id',
                'order_id' => '订单id',
                'money' => ['冻结金额(元)', function($In) {return $this->formatAmount($In);}],
                'freeze_queryid' => '冻结流水号',

                'datetime' => '冻结时间',
                'created_at' => '创建时间',
            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',

        ];
    }

    /**
     * 属于自己的订单列表显示属性
     * @return array
     */
    public function getMyOrderParams()
    {
        return [
            'title' => '业务员列表',
            'fields' => [
                'num' => '订单',
                'car_owner' => '车主',
                'car_license_plate' => '车牌',
                'amount' => ['期数', function ($in) {
                    return $this->formatAmount_($in);
                }],
                'policy_type' => '保单类型',
                'ft' => '来源类型',
                'created_at' => '创建时间', //增添一个创建时间
                'status' => ['状态', function ($in) {
                    return $this->formatStatus($in);
                }],

            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.carInsurance.order.show',

                ],
                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'route' => 'backend.carInsurance.order.edit',
                    'width' => 800,
                    'height' => 700,
                ],
                /*[
                    'type' => 'delete',
                    'title' => '删除',
                    'route' => 'backend.carInsurance.order.destroy',
                    'width' => 800,
                    'height' => 700,
                ],*/
                [
                    'type' => 'download',
                    'title' => '下载',
                    'route' => 'backend.carInsurance.order.download',
                ]
            ],
        ];
    }

    public function getFailOrderSearchParams()
    {
        return [
            'route' => 'backend.carInsurance.chargeBackFail',
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
                    'name' => 'owner_mobile',
                    'placeholder' => '移动电话',
                    'class' => 'input-text Wdate'
                ],

                [
                    'type' => 'date',
                    'name' => 'created_at',
                    'placeholder' => '创建时间',
                ],
            ],
        ];
    }

    public function getFailOrderTableParams()
    {
        return [
            'title' => '异常订单',
            'fields' => [
                'num' => '订单',
                'car_owner' => '车主',
                'owner_mobile'=>'移动电话',
                'car_license_plate' => '车牌',
                'amount' => ['期数', function ($in) {
                    return $this->formatAmount_($in);
                }],
                'policy_type' => '保单类型',
                'error' => '错误号码',
                'created_at' => '创建时间', //增添一个创建时间
                'status' => ['状态', function ($in) {
                    return $this->formatStatus($in);
                }],

            ],

            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '订单详情',
                    'text' => '详情',
                    'route' => 'backend.carInsurance.order.show',

                ],
                /*[
                    'type' => 'edit',
                    'title' => '编辑',
                    'route' => 'backend.carInsurance.order.edit',
                    'width' => 800,
                    'height' => 700,
                ],*/
                /*[
                    'type' => 'delete',
                    'title' => '删除',
                    'route' => 'backend.carInsurance.order.destroy',
                    'width' => 800,
                    'height' => 700,
                ],*/
                /*[
                    'type' => 'download',
                    'title' => '下载',
                    'route' => 'backend.carInsurance.order.download',
                ]*/
            ],
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 16:51
 */

namespace App\Presenters;


use App\Traits\Presenter\BasePresenterTrait;

class WaterPurifierPresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route' => 'backend.waterPurifier.index',
            'inputs' => [
                [
                    'type' => 'select',
                    'name' => 'is_complete',
                    'options' => ['1' => '已填完', 0 => '未填完'],
                    'class' => 'select'
                ],
                [
                    'type' => 'select',
                    'name' => 'backend_order',
                    'options' => [''=>'订单生成途径',"0"=>'微信端创建',"1"=>'后台创建'],
                    'class' => 'select'
                ],

                [
                    'type' => 'text',
                    'name' => 'id',
                    'placeholder' => '编号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => '名字',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'sale_code',
                    'placeholder' => '推荐代码',
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

    public function formatStatus($status)
    {
        switch ($status) {
            case 0:
                return "录入";
            case 1:
                return "扣首款";
            case 2:
                return "生效";
        }
    }
    public function createType($backend_order)
    {
        switch ($backend_order) {
            case 0:
                return "微信端创建";
            case 1:
                return "后台创建";

        }
    }

    public function formatErrorInstallmentStatus($opertion_time, $status)
    {
        $now = date('Y-m-d H:i:s');
        if ($opertion_time < $now && $status == '0') {
            return '订单异常';
        } else {
            switch ($status) {
                case 0:
                    return "录入";
                case 1:
                    return "扣首款";
                case 2:
                    return "生效";
            }
        }

    }


    public function formatDebit($status)
    {
        switch ($status) {
            case 0:
                return "未扣款";
            case 1:
                return "已扣款";
        }
    }

    public function formatComplete($status)
    {
        switch ($status) {
            case 0:
                return "未填完";
            case 1:
                return "已填完";
        }
    }

    public function formatIsInstall($is_install)
    {
        switch ($is_install) {
            case 1:
                return '未安装';
                break;
            case 2:
                return '已安装';
                break;
            default:
                return '未知安装状态';
        }
    }


    /**
     * 如果fields内无[0,1]到[描述，描述]的函数映射，无需使用数组，例如 'is_install'=>'是否安装',不要写成'is_install'=>['是否安装']
     * 如果有相应的映射要求，则需要写成'is_install'=>['描述', function($key){}],匿名函数用于转换状态码到具体的描述
     * @return array
     */
    public function getTableParams()
    {
        return [
            'title' => '净水器订单',
            'fields' => [

                'id' => '编号',
                'num' => '订单号',
                'name' => '名字',
                'mobile' => '移动电话',
                'is_install' => ['是否安装', function ($is_install) {
                    return $this->formatIsInstall($is_install);
                }],


//                'province'  => '省份',
//                'city'  => '城市',
//                'area'  => '地区',
                'sale_code' => '推荐代码',
                'created_at' => '订单创建时间',
                'status' => ['主状态(0;录入;1:扣首款;2:生效)', function ($status) {
                    return $this->formatStatus($status);
                }],
                'is_debit' => ['扣款状态(0;未扣款;1:已扣款)', function ($debit) {
                    return $this->formatDebit($debit);
                }],
                'is_complete' => ['填写状态(0;未填完;1:已填完)', function ($complete) {
                    return $this->formatComplete($complete);
                }],
            ],
            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
//                [
//                    'type'  => 'delete',
//                    'title' => '删除',
//                    'route' => 'backend.waterPurifier.destroy',
//                ],
                [
                    'type' => 'admin_tab',
                    'title' => '净水器:订单详情',
                    'text' => '订单详情',
                    'route' => 'backend.waterPurifier.show',

                ],
            ],
        ];
    }

    /**
     * 获取分期信息需要的搜索参数
     */
    public function getInstallmentSearchParams()
    {
        return [
            'route' => 'backend.waterPurifier.installments',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => '名字',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'mobile',
                    'placeholder' => '移动电话',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'opertion_time',
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

    public function formatMoney($money)
    {
        return "¥" . round($money / 100, 2);
    }

    public function formatDebitMoney($debitMoney)
    {
        return "¥" . round($debitMoney / 100, 2);
    }

    public function formatInstallmentStatus($status)
    {
        switch ((int)$status) {
            case 0:
                return "未扣款";
            case 1:
                return '扣款中';
            case 2:
                return "已扣款";
            default:
                return '异常';
        }
    }

    /**
     * 获取分期信息表参数信息
     */
    public function getInstallmentTableParams()
    {
        return [
            'title' => '净水器订单',
            'fields' => [
                'id' => '编号',
                'num' => '订单号',
                'name' => '名字',
                'mobile' => '移动电话',
                'opertion_time' => '扣款时间',
//                'province'  => '省份',
//                'city'  => '城市',
//                'area'  => '地区',
                'money' => ['扣款金额', function ($value) {
                    return $this->formatMoney($value);
                }],
                'debit_money' => ['已扣金额', function ($value) {
                    return $this->formatDebitMoney($value);
                }],
                'error_count' => '扣款失败次数',
                'status' => ['状态', function ($value) {
                    return $this->formatInstallmentStatus($value);
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

    /**
     * 扣款失败需要的参数信息
     * @return array
     */
    public function getFailSearchParams()
    {
        return [
            'route' => 'backend.waterPurifier.chargeBackFail',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => '名字',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'mobile',
                    'placeholder' => '移动电话',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'opertion_time',
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

    public function getDeviceInfoSearchParams()
    {
        return [
            'route' => 'backend.waterPurifier.deviceInfo',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'device_id',
                    'placeholder' => '设备号',
                    'class' => 'input-text Wdate'
                ],
                /*[
                    'type'        => 'text',
                    'name'        => 'mobile',
                    'placeholder' => '移动电话',
                    'class'       => 'input-text Wdate'
                ],*/
                [
                    'type' => 'date',
                    'name' => 'datetime',
                    'placeholder' => '维护时间',
                    'class' => 'input-text Wdate'
                ]
            ],
        ];
    }

    public function hasMaintained($it)
    {
        switch ((int)$it) {
            case 0:
                return "未执行";
            case 1:
                return "已执行";
        }
    }

    public function getDeviceInfoTableParams()
    {
        return [
            'title' => '净水器订单',
            'fields' => [
                //'id' => '订单id',
                'device_id' => '设备id',
                'id' => '订单id',
                'num' => '订单号',
                'datetime' => '维护日期',
                'is_complete' => ['是否完成维护', function ($it) {
                    return $this->hasMaintained($it);
                }],
                'operation' => '操作',
//                'opertion_time' => '操作',
//                'province'  => '省份',
//                'city'  => '城市',
//                'area'  => '地区',
//                'money' => ['扣款金额', function($value) {return $this->formatMoney($value);}],
//                'debit_money' => ['已扣金额', function($value) {return $this->formatDebitMoney($value);}],
//                'error_count' => '扣款失败次数',
//                'status' => ['状态', function($value) {return $this->formatInstallmentStatus($value);}],
//                'remark' => '备注'
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
                    'type' => 'admin_tab', //不展示的意思
                    'title' => '净水器:订单详情',
                    'text' => '订单详情',
                    'route' => 'backend.waterPurifier.show',

                ],
            ]
        ];
    }

    /**
     * 分期汇总消息的search参数获取
     */
    public function getCollectSearchParams()
    {
        return [
            'route' => 'backend.waterPurifier.installmentCollect',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'num',
                    'placeholder' => '订单号',
                    'class' => 'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'device_id',
                    'placeholder' => '设备号',
                    'class' => 'input-text Wdate'
                ],
                /*[
                    'type'        => 'text',
                    'name'        => 'mobile',
                    'placeholder' => '移动电话',
                    'class'       => 'input-text Wdate'
                ],*/
                [
                    'type' => 'date',
                    'name' => 'datetime',
                    'placeholder' => '维护时间',
                    'class' => 'input-text Wdate'
                ]
            ],
        ];
    }

    /**
     * 同理
     */
    public function getCollectTableParams()
    {
        return [
            'title' => '净水器订单',
            'fields' => [
                //'id' => '订单id',
                'device_id' => '设备id',
                'id' => '订单id',
                'num' => '订单号',
                'datetime' => '维护日期',
                'is_complete' => ['是否完成维护', function ($it) {
                    return $this->hasMaintained($it);
                }],
                'operation' => '操作',
            ],
            'handleWidth' => '130px',
            'handle' => [
//                [
//                    'type'  => 'delete',
//                    'title' => '删除',
//                    'route' => 'backend.waterPurifier.destroy',
//                ],
                [
                    'type' => 'admin_tab',
                    'title' => '净水器:订单详情',
                    'text' => '订单详情',
                    'route' => 'backend.waterPurifier.show',

                ],
            ]
        ];
    }

    /**
     * 供前台净水器订单搜索使用的搜索参数
     */
    public function getSearchParamsForFrontend()
    {
        return [
            'route' => 'frontend.fromtype.index',
            'inputs' => [
                [
                    'type' => 'select',
                    'name' => 'status',
                    'placeholder' => '订单状态',
                    'options' => ['0' => '录入', '1' => '扣首款', '2' => '生效'],
                    'class' => 'select'
                ],
                [
                    'type' => 'date',
                    'name' => 'created_at',
                    'placeholder' => '创建时间',
                    'class' => 'input-text Wdate'
                ],
            ],
        ];
    }

    /**
     * 供前台净水器订单操作使用的操作参数
     *
     * <<<<<<< HEAD
     * @return array
    =======
     * @return array:
     * >>>>>>> tmp-1215
     */
    public function getHandleParamsForFrontend()
    {
        return [

        ];
    }

    /**
     * 供前台使用
     *
     * @return array:
     */
    public function getTableParamsForFrontend()
    {
        return [
            'title' => '净水器订单',
            'fields' => [
                'id' => '编号',
                'num' => '订单号',
                'name' => '名字',
                'mobile' => '移动电话',
                'city' => '城市',
                'area' => '地区',
                'created_at' => '订单创建时间',
                'status' => ['主状态(0;录入;1:扣首款;2:生效)', function ($status) {
                    return $this->formatStatus($status);
                }],
                'is_debit' => ['扣款状态(0;未扣款;1:已扣款)', function ($debit) {
                    return $this->formatDebit($debit);
                }],
            ],
            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
// 	    		[
// 		    		'type'  => 'admin_tab',
// 		    		'title' => '净水器:订单详情',
// 		    		'text'  => '订单详情',
// 		    		'route' => 'backend.waterPurifier.show',
// 	    		],
            ],
        ];
    }

}
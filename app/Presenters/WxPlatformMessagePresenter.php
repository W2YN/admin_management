<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformMessagePresenter extends CommonPresenter
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
        return number_format($value / 100, 2) . '元';
    }


    public function showType($type)
    {
        if ($type == 1) {
            return "文本";
        }
        if ($type == 2) {
            return "图片";
        }

    }

    public function showReturnType($type)
    {
        if ($type == 1) {
            return "文本";
        }
        if ($type == 2) {
            return "图文";
        }
        if ($type == 3) {
            return "多图文";
        }
        if ($type == 4) {
            return "跳转";
        }

    }


//    public function getSearchParams()
//    {
//        return [
//            'route' => 'backend.rbcx.index',
//            'inputs' => [
//                [
//                    'type' => 'text',
//                    'name' => 'num',
//                    'placeholder' => '订单号',
//                    'class' => 'input-text Wdate'
//                ],
//                [
//                    'type' => 'text',
//                    'name' => 'car_owner',
//                    'placeholder' => '车主',
//                    'class' => 'input-text Wdate'
//                ],
//                [
//                    'type' => 'text',
//                    'name' => 'mobile',
//                    'placeholder' => '手机号',
//                    'class' => 'input-text Wdate'
//                ],
//                [
//                    'type'    => 'select',
//                    'name'    => 'status',
//                    'options' => [''=>'请选择',"1"=>'未扣款',"2"=>'已扣款','3'=>'已出保单'],
//                    'class'   => 'select',
//                    'placeholder' => '状态：',
//                ],
//            ],
//
//        ];
//    }

    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.wxmessage.create',
                'icon' => '&#xe600;',
                'class' => 'success',
                'title' => '新增',
                'click' => "frame_window_open_full('新增消息回复','" . route('backend.wxmessage.create') . "')"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title' => '消息管理',
            'fields' => [
                'id' => 'id',
                'message_name' => '用户消息内容',
//                'type_id' => ['消息类型', function($value){return $this->showType($value);}],
                'return_id' => ['回复类型', function ($value) {
                    return $this->showReturnType($value);
                }],

            ],
            'handleWidth' => '140px',
            'handle' => [

                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'width' => '50',
                    'height' => '50',
                    'route' => 'backend.wxmessage.edit',
                ],
                [
                    'type' => 'delete',
                    'title' => '删除',
                    'width' => '50',
                    'height' => '50',
                    'route' => 'backend.wxmessage.destory',
                ],
            ],
        ];
    }

}

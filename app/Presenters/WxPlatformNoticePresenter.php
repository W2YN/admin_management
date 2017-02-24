<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformNoticePresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */
    
    public function showOpenid($openid)
    {
        if ($openid == '') {
            return "群发";
        }
        else{
            return $openid;
        }


    }
    public function showSendType($type)
    {
        if ($type == '0') {
            return "未发送";
        }
        else{
            return '已发送';
        }


    }

    public function showReturnType($type)
    {
        if ($type == 1) {
            return "文本";
        }
        if ($type == 2){
            return "图文";
        }
        if ($type == 3){
            return "跳转";
        }

    }
//    public function showScribeTime($time)
//    {
//
//
//    }


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
                'route' => 'backend.wxnotice.create',
                'icon' => '&#xe600;',
                'class' => 'success',
                'title' => '新增',
                'click' => "frame_window_open_full('新增通知','" . route('backend.wxnotice.create') . "')"
            ],
        ];
    }


    public function getTableParams()
    {
        return [
            'title' => '微信用户列表',
            'fields' => [
                'id' => 'id',
                'notice_name' => '通知名称',
                'openid' => ['通知对象', function($value){return $this->showOpenid($value);}],
                'return_id' => ['回复类型', function($value){return $this->showReturnType($value);}],
'is_send'=>['发送状态', function($value){return $this->showSendType($value);}],
            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'width'=>'50',
                    'height'=>'50',
                    'route' => 'backend.wxnotice.edit',
                ],
            ],
        ];
    }

}

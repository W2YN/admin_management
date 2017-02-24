<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformEventPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */
    
    public function showEventName($name)
    {
        if ($name == 'subscribe') {
            return "用户订阅";
        }
        if ($name == 'LOCATION'){
            return "用户提交地理位置";
        }
        if ($name == 'click'){
            return '用户点击菜单';
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



    public function getTableParams()
    {
        return [
            'title' => '事件管理',
            'fields' => [
                'id' => 'id',
                'event_name' => ['事件类型', function($value){return $this->showEventName($value);}],
//                'type_id' => ['消息类型', function($value){return $this->showType($value);}],
                'return_id' => ['回复类型', function($value){return $this->showReturnType($value);}],

            ],
            'handleWidth' => '140px',
            'handle' => [

                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'width'=>'50',
                    'height'=>'50',
                    'route' => 'backend.wxevent.edit',
                ],

            ],
        ];
    }

}

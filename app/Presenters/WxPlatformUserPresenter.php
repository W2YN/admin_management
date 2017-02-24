<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformUserPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */
    
    public function showSex($sex)
    {
        if ($sex == '1') {
            return "男";
        }
        else{
            return '女';
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



    public function getTableParams()
    {
        return [
            'title' => '微信用户列表',
            'fields' => [
                'id' => 'id',
                'nickname' => '用户名',
                'sex' => ['性别', function($value){return $this->showSex($value);}],
                'city'=>'城市',
                'openid' => '微信openid',
            ],
            'handleWidth' => '140px',
            'handle' => [
            ],
        ];
    }

}

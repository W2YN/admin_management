<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformTemplateMessagePresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */

    public function showSend($status)
    {

        if ($status == 1) {
            return '已发送';
        } else {
            return '未发送';
        }
    }
    public function showDelay($status){
        if ($status == 1){
            return '延迟发送';
        }
        else{
            return '即时发送';
        }
    }
    public function showMsg($value){
        if ($value == 'ok'){
            return '发送成功';
        }
        else{
            return '发送异常';
        }
    }
//    public function showResult($status)
//    {
//
//        if ($status == 'success') {
//            return '发送成功';
//        } else {
//            return '发送失败';
//        }
//    }

    public function getSearchParams()
    {
        return [
            'route' => 'backend.wxtemplatemessage.index',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'templateId',
                    'placeholder' => '模板id',
                    'class' => 'input-text Wdate'
                ],

                [
                    'type' => 'text',
                    'name' => 'openId',
                    'placeholder' => '用户id',
                    'class' => 'input-text Wdate'
                ],
//                [
//                    'type' => 'select',
//                    'name' => 'orderStatus',
//                    'options' => ['0' => '已接受', "1" => '处理中', "2" => '处理成功', '3' => '处理失败'],
//                    'class' => 'select',
//                    'placeholder' => '状态：',
//                ],

            ],

        ];
    }

//    public function getHandleParams()
//    {
//        return [
//            [
//
//                'icon' => '',
//                'class' => 'success',
//                'title' => '同步模板',
//                'click' => "frame_window_open_full('新增消息回复','" . route('backend.wxmessage.create') . "')"
//            ],
//        ];
//    }
//
    public function getTableParams()
    {
        return [
            'title' => '微信模板消息列表',
            'fields' => [
                'id' => 'id',
                'templateId' => '模板id',
                'openId' => '用户id',
                'issend' => ['是否已发送', function ($value) {
                    return $this->showSend($value);
                }],
                'errmsg'=>['发送信息', function ($value) {
                    return $this->showMsg($value);
                }],
           

            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '详情',
                    'text' => '详情',
                    'route' => 'backend.wxtemplatemessage.show',

                ],
            ],
        ];
    }

}

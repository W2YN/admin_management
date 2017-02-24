<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformTemplatePresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */

    public function showStatus($status)
    {


    }


    public function getHandleParams()
    {
        return [
            [

                'icon' => '',
                'class' => 'success',
                'title' => '同步模板',
                'click' => "synchronizeTemplate()"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title' => '微信模板消息列表',
            'fields' => [
                'id' => 'id',
                'templateId' => '模板id',
                'title' => '模板标题'

            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'show',
                    'title' => '详情',
                    'text' => '详情',
                    'route' => 'backend.template.show',

                ],
            ],
        ];
    }

}

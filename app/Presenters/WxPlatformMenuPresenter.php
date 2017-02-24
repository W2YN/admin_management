<?php

namespace App\Presenters;

use App\Repositories\WxPlatform\WxMenuRepository;
use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class WxPlatformMenuPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */

    public function showLevel($status)
    {
        if ($status == 1) {
            return '一级菜单';
        } else {
            return '二级菜单';
        }

    }
    public function showBelong($status)
    {
        if ($status == 0) {
            return '顶级菜单';
        } else {
            return WxMenuRepository::getInstance()->showBelong($status);
        }

    }
    public function showOrder($id)
    {

            return WxMenuRepository::getInstance()->showOrder($id);


    }


    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.wxmenu.create',
                'icon' => '&#xe600;',
                'class' => 'success',
                'title' => '新增',
                'click' => "frame_window_open_full('新增菜单','" . route('backend.wxmenu.create') . "')"
            ],
            [

                'icon' => '',
                'class' => 'primary',
                'title' => '更新菜单',
                'click' => "synchronizeMenu()"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title' => '微信菜单管理',
            'fields' => [
                'id' => 'id',
//                'level' => ['菜单等级', function ($value) {
//                    return $this->showLevel($value);
//                }],
                'order'=>'菜单顺序',
                'level_id' => ['所属菜单', function ($value) {
                    return $this->showBelong($value);
                }],
                'name' => '菜单名字'

            ],
            'handleWidth' => '140px',
            'handle' => [
                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'text' => '编辑',
                    'width'=>'50',
                    'height'=>'50',
                    'route' => 'backend.wxmenu.edit',

                ],
                [
                    'type' => 'delete',
                    'title' => '删除',
                    'width'=>'50',
                    'height'=>'50',
                    'route' => 'backend.wxmenu.destory',
                ],

            ],
        ];
    }

}

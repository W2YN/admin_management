<?php

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;
use App\Facades\MenuRepository;

/**
 * Menu View Presenters
 */
class MenuPresenter extends CommonPresenter
{
    use  BasePresenterTrait;

    /**
     * 格式化显示隐藏状态
     *
     * @param  int $status
     *
     * @return string
     */
    public function showDisplayFormat($status)
    {
        if ($status) {
            return "隐藏";
        } else {
            return "显示";
        }
    }

    public function getSearchParams()
    {
        return [
            'route'  => 'backend.menu.search',
            'inputs' => [
                [
                    'type'    => 'select',
                    'name'    => 'parent_id',
                    'options' => MenuRepository::getAllTopMenus(),
                    'class'   => 'select'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'description',
                    'placeholder' => '菜单描述',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type'        => 'text',
                    'name'        => 'name',
                    'placeholder' => '菜单名称',
                    'class'       => 'input-text Wdate'
                ],
                [
                    'type' => 'date',
                    'name' => 'created_at',
                ],
            ],
        ];
    }

    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.menu.create',
                'icon'  => '&#xe600;',
                'class' => 'success',
                'title' => '新增菜单',
                'click' => "frame_window_open('新增菜单','".route('backend.menu.create')."','800')"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title'  => '菜单管理',
            'fields' => [
                'id'    => '菜单编号',
                'description'  => '菜单描述',
                'name'  => '菜单名称',
                'route' => '菜单路由',
                'sort'  => '菜单排序',
                'hide'  => '是否显示',
            ],
            'handle' => [
                [
                    'type'  => 'edit',
                    'title' => '编辑',
                    'route' => 'backend.menu.edit',
                ],
                [
                    'type'  => 'delete',
                    'title' => '删除',
                    'route' => 'backend.menu.destroy',
                ],
            ],
        ];
    }
}

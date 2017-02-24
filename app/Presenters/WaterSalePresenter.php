<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 16:51
 */

namespace App\Presenters;


use App\Traits\Presenter\BasePresenterTrait;

class WaterSalePresenter
{
    use  BasePresenterTrait;


    public function getSearchParams()
    {
        return [
            'route' => 'backend.waterSale.index',
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => '业务员',
                    'class' => 'input-text Wdate'
                ],
            ],
        ];
    }


    public function getHandleParams()
    {
        return [
            [
                'route' => 'backend.waterSale.create',
                'icon' => '&#xe600;',
                'class' => 'success',
                'title' => '增加业务员',
                'click' => "frame_window_open('增加业务员','" . route('backend.waterSale.create') . "','400','400')"
            ],
        ];
    }

    public function getTableParams()
    {
        return [
            'title' => '业务员列表',
            'fields' => [
                'id' => '编号',
                'name' => '名称',
                'code' => '推荐代码',
                'discount_type' => ['优惠类型', function ($value) {
                    if ($saleDiscountType = config('water.saleDiscountType.' . $value)) {
                        return $saleDiscountType;
                    }
                    //return '未知';
                }],
                'discount_value' => ['优惠值', function ($value, $data) {
                    switch ($data->discount_type) {
                        case 1:
                            return ($value / 100) . '元';
                        case 2:
                            return $value . '%';

                    }
                }],
            ],
            'fieldWidth' => [
                'id' => '30px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'edit',
                    'title' => '编辑',
                    'width' => '400',
                    'height' => '400',
                    'route' => 'backend.waterSale.edit',
                ],
                [
                    'type' => 'delete',
                    'title' => '删除',
                    'route' => 'backend.waterSale.destroy',
                ],

            ],
        ];
    }

}
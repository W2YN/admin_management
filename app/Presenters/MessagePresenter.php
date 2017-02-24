<?php
/**
 * MessagePresenter.php
 * Date: 2016/10/24
 */

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;

class MessagePresenter
{
    use BasePresenterTrait;

    //搜索条目的配置信息
    //暂时没有需要搜索的条目
    public function searchParams()
    {
        return [
            "route" => "backend.message.index",
            "inputs"=>[
                [
                    "type" => "select",
                    "name" => "is_read",
                    'options'=>['0'=>'未读取', '1'=>'已读取'],
                    'class' => 'select'
                ],
                [
                    'type' => "text",
                    'name'=> 'title',
                    'placeholder'=> '标题',
                    'class'=>'input-text Wdate'
                ],
                [
                    'type' => 'text',
                    'name' => 'level',
                    'placeholder' => '紧急程度',
                    'class' => 'input-text Wdate'
                ]
            ]
        ];
    }

    //这是干嘛的
    public function handleParams()
    {
        return [];
    }

    function format_read($is_read){
        if($is_read == 0) return "未读";
        else return "已读";
    }

    //。。。
    public function tableParams()
    {
        return [
            "title" => "消息列表",
            'fields' => [
                'id' => '编号',
                'from' => '来源id',
                'from_name'=> '来源名称',
                'title' => '标题',
                'level'=>'紧急程度',
                'is_read' => ['状态', function($is_read){return $this->format_read($is_read);}],
                'created_at'=>"创建于"
            ],
            'fieldWidth' =>[
                'id' => '60px',
                'from' => '60px',
                'from_name'=>'80px',
                'is_read' => '80px',
                'created_at'=>'140px',
            ],
            'handleWidth' => '120px',
            'handle' => [
                [
                    'type' => 'sure', //自定义tab
                    'title' => '读取',
                    'text'=> '详情',
                    //'state'=> 0,//0->未读,1->已读 自定义字段
                    'route' => 'backend.message.read',
                    'width' => '320px',
                    'height' => '80px',
                ],
            ]
        ];
    }

}
<?php
/**
 * LoggerPresenter.php
 * Date: 2016/10/24
 */

namespace App\Presenters;

use App\Traits\Presenter\BasePresenterTrait;

class ActionLoggerPresenter
{
    use BasePresenterTrait;

    //搜索条目的配置信息
    public function getSearchParams()
    {
        return [
            "route" => "backend.actionLogger.index",
            "inputs" => [
                [
                    "type" => "text",
                    "name" => "url",
                    "placeholder" => "操作url",
                    'class' => "input-text Wdate"
                ],
            ]
        ];
    }

    //这个干吗用的?
    public function getHandleParams()
    {
        return [];
    }

    //$type(int) -> string的映射
    private function format_type($type)
    {
        //insert code here
        return $type;
    }

    //列表参数信息
    public function getTableParams()
    {
        return [
            "title" => "用户操作日志列表",
            'fields' => [
                'id' => '编号',
                'user_name' => '操作者',
                'type' => ['操作类型',function($type) {return $this->format_type($type);}],
                'url' => '提交url',
                'method' => 'http方法',
                "params" => '提交参数',
                'desc' => '操作描述',
                'created_at' => '创建时间'
            ],
            'fieldWidth' => [
                "id" => "20px",
            ],
            "handleWidth" => "100px", //这一栏最窄就好
            'handle' => [
                [
                    "type" => 'show', //必须要详情
                    'title' => '用户日志:详情',
                    'text' => '详情',
                    "route" => 'backend.actionLogger.show'
                ],
            ]
        ];
    }

    //分页时需要获取到的列信息
    public function retrieveColumn()
    {
        return [
            'operation_logs.id',
            'operation_logs.user_id',
            'users.name as user_name',
            'operation_logs.type',
            'operation_logs.url',
            'operation_logs.method',
            'operation_logs.params',
            'operation_logs.desc',
            'operation_logs.created_at'
        ];
    }
}
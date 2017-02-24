<?php
/**
 * ActionLogService.php
 * Date: 2016/11/22
 */

namespace App\Services;
use App\Models\ActionLogger;
use Illuminate\Support\Facades\Event;

/**
 * Class ActionLogService 用于操作operation日志之用
 * @package App\Services
 */
class ActionLogService
{
    /**
     * @var ActionLogger
     */
    static $log = '';

    /**
     * 如果不触发OperationEvent事件，那么不会存储操作日志到数据库中
     * @param $param array
     */
    public static  function operationLog($param)
    {
        $log = new ActionLogger;
        foreach($param as $key=>$value){
            $log->$key = $value;
        }
        //$log->save();
        self::$log = $log;
        //session()->set(self::OperationId, $log->id);
    }

    public static function updateOperationLog($desc)
    {
        self::$log->desc = $desc;
        self::$log->save();
    }
}
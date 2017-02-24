<?php
/**
 * LogRepository.php
 * Date: 2016/10/20
 */

namespace app\Repositories;

use App\Facades\HelpFacades;
use App\Http\Requests\Request;
use App\Models\ActionLogger;
//use App\Presenters\LoggerPresenter;

class ActionLoggerRepository extends CommonRepository
{
    public static $accessor = "operation_log_repository";

    /**
     * @return ActionLoggerRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    public function log($user_id, $type, $desc, $params='', $url='', $method=''){
        $log = $this->create([
            "user_id"=> $user_id,
            "type" => $type,
            'url' => $url,
            "method" => $method,
            'params' => $params,
            'desc' => $desc
        ]);
        return $log;
    }

    function logByRequest($user_id, $type, $desc, \Illuminate\Http\Request $request){
        $uriInfo = action_logger_params($request);
        return $this->log($user_id, $type, $desc, $uriInfo['params'], $uriInfo['url'], $uriInfo['method']);
    }

    /**
     * 通过$id获取log
     * @param $id integer
     */
    public function getLogThrough($id)
    {
        return ActionLogger::find($id);
    }

    /**
     * 通过指定时间段来获取log
     * @param $from string   Y-m-d h:i:s
     * @param $to   string   Y-m-d h:i:s

     */
    public function getLogBetween($from, $to)
    {
        $where = [["created_at", 'between', [$from, $to]]];
        $logs = $this->getByWhere($where);
        if(count($logs) > 0) return $logs;
        else return null;
    }

    public function joinPaginateWhere($where, $limit)
    {
        $model = $this->model;
        //$columns = (new LoggerPresenter())->retrieveColumn();
        $columns = [
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
        $this->model = $model->leftJoin('users', 'users.id', '=', 'operation_logs.user_id');
        return parent::paginateWhere($where, $limit, $columns);
    }
}
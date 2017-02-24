<?php
/**
 * LoggerController.php
 * Date: 2016/10/24
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
//use App\Models\Log;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use App\Repositories\ActionLoggerRepository;

class ActionLoggerController extends Controller
{
    public function __construct()
    {
        //加载中间件
        $this->middleware("search", ['only' => 'index']);
    }

    /*
     * 管理员操作日志首页加载
     * @return Response
     */
    public function index(Request $request)
    {
        $where = $request->get("where");

        $data = ActionLoggerRepository::getInstance()->joinPaginateWhere($where, config('repository.page-limit'));

        return view('backend.actionLogger.index', compact("data"));
    }

    /*
     * 单个操作的具体展示页面
     */
    public function show(Request $request)
    {
        $id = $request->get("id");
        $where = [['operation_logs.id', '=', $id]];

        $data= ActionLoggerRepository::getInstance()->joinPaginateWhere($where, 1);

        $data = $data[0];

        return view('backend.actionLogger.show', compact("data"));

    }

    /**
     * API ????
     * @param Request $request
     */
    /*public function log(Request $request)
    {
        //logger_params();
        $params = full_logger_params($request);
        $log = LogRepository::getInstance()->log($params);
        $log = LogRepository::getInstance()->log2($user_id, $type, $desc, $request);
        $log = LogRepository::getInstance()->log1($user_id, $type, $desc, 'zzz','http://xxx','get');
        if($log) return 1; //成功
        else return 0;//失败了
    }*/
}
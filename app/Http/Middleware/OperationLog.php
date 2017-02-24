<?php
/**
 * ActionLogger.php
 * Date: 2016/11/22
 */

namespace App\Http\Middleware;

use App\Services\ActionLogService;
use Closure;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = action_logger_params($request);

        $user = \Auth::user();

        $params['user_id'] = $user->id;

        $params['type'] = '系统记录';

        ActionLogService::operationLog($params);

        return $next($request);
    }
}
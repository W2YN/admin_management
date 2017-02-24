<?php
/**
 * TestController.php
 * Date: 2016/10/20
 */

namespace App\Http\Controllers\Backend\CarInsurance;

use App\Events\Log\OperationEvent;
use App\Http\Controllers\Controller;
use Event;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware("logger.operation");
    }

    public function test()
    {
        //ActionLogService::updateLogAction("")
        Event::fire(new OperationEvent("测试操作而已"));
        echo "test is test..";
    }
}
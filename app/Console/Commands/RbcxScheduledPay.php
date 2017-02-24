<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rbcx\Order;
use App\Services\PayService;
use DB;

class RbcxScheduledPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbcx:scheduledPay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '人保车险周期性扣款';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        //DB::connection('mysql_rbcx')->statement("set autocommit=0");
      //  DB::connection('mysql_rbcx')->beginTransaction();
        $orders = Order::chargedValidOrder();
        \Log::info("\n\n后台扣款===>找到到期订单 ". count($orders) ." 张");
        foreach($orders as $order) {
            if($order instanceof Order) {

                $orderId = $order->id;
                \Log::info("【人保车险代扣 后台扣款】==============处理订单： $orderId"  . "==============");
                try{ //开始扣款
                    PayService::scheduledPay($order);
                }catch(\Exception $e){
                    $order->markError(1); //1-> | 2->
                    \Log::info("【人保车险代扣 后台扣款】异常:订单{{$orderId}}扣款失败， 错误信息:". $e->getMessage());
                }
            }
        }
        \Log::info("【人保车险代扣 后台扣款】订单扣款结束=================");
       // DB::connection('mysql_rbcx')->commit();
       // DB::connection('mysql_rbcx')->statement("set autocommit=1");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Rbcx\Installment;
use Illuminate\Console\Command;
use Log;

class RbcxSendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:rbcx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info("【人保车险】发送短信扣款提醒 开始====================" );

        $today = date('Y-m-d 00:00:00');
        $todayTime = strtotime($today);
        $fiveTime = strtotime("+5 day", $todayTime );
        $sixTime = strtotime("+6 day", $todayTime );
        $five = date('Y-m-d 00:00:00',$fiveTime);
        $six = date('Y-m-d 00:00:00',$sixTime);

        $datas = Installment::whereBetween('opertiontime', [$five,$six])->get();

        foreach( $datas as $data ){
            $order = $data->order()->first();
            if( !$order ){
                Log::error("【人保车险】发送短信 订单不存在 分期ID：" . $data->id );
                continue;
            }

            if( $order->is_delete != 0 ){
                Log::error("【人保车险】发送短信 订单已删除 订单ID：" . $order->id );
                continue;
            }

            if( $order->enable != 1 ){
                Log::error("【人保车险】发送短信 订单已禁用 订单ID：" . $order->id );
                continue;
            }

            if( $order->first_charge != 1 ){
                Log::error("【人保车险】发送短信 订单还未完成首次付款 订单ID：" . $order->id );
                continue;
            }

            $card = $order->cardInfo()->first();
            if( !$card ){
                Log::error("【人保车险】发送短信 银行卡信息不存在 分期ID：" . $data->id . " 订单ID：" . $order->id );
                continue;
            }

            $opertiontime = strtotime( $data->opertiontime );
            $opertiontime = date('m月d日',$opertiontime);
            $total = $order->business_money + $order->force_money + $order->travel_tax;
            $total = number_format( $total/100, 2 );
            $money = number_format( $data->money/100, 2 );
            $cardNumber = substr( $card->card, -4 );

                //初始化
            $curl = curl_init();
            //设置抓取的url
            curl_setopt($curl, CURLOPT_URL, env('API_SMS_URL'));
            //设置头文件的信息作为数据流输出
            //curl_setopt($curl, CURLOPT_HEADER, 1);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            $post_data = [
                'mobiles' => $card->phone_number,
                'content' => "尊敬的车险分期客户，{$order->license_plate}车辆的车险分期费将于{$opertiontime}扣当期费用，金额为{$money}元。请您确保绑定信用卡(尾号{$cardNumber})的正常使用。如有疑问，请拨打0571-28881000咨询。",
                'opertion_time' => date('Y-m-d 11:00:00')
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            //执行命令
            $data = curl_exec($curl);
            //关闭URL请求
            curl_close($curl);
            //显示获得的数据
            $data = json_decode($data, true);
            if( $data['code'] != 200 ){
                Log::error("【人保车险】发送短信失败 订单ID：" . $order->id . " 手机号码：" . $card->phone_number ); // . //json_encode(, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );
            }
            //exit;

        }

        Log::info("【人保车险】发送短信扣款提醒 结束====================" );
    }
}

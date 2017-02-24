<?php

namespace App\Console\Commands;

use App\Repositories\Sms\SmsRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

define('SCRIPT_ROOT', __DIR__ . '/../../Other/yimei/');

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时发送短信';

    protected $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = config('sms.yimei');
    }

    /**
     * Execute the console command.
     * @return mixed
     * @throws \App\Traits\Repository\Exception
     * @throws \Exception
     */
    public function handle()
    {
        $smss = SmsRepository::getInstance()->getByWhere([
            [ 'is_send', '=', 0 ],
            [ 'opertion_time', '<=', date('Y-m-d H:i:s') ],
        ]);

        if( count( $smss ) <= 0 ){
            return ;
        }

        require_once SCRIPT_ROOT . 'include/Client.php';
        $gwUrl = 'http://sdk4http.eucp.b2m.cn/sdk/SDKService?wsdl'; // 备用接口
        $serialNumber = $this->config['serialNumber'];//'3SDK-EMY-0130-OGZTL';
        $password = $this->config['password'];//'930573';
        $sessionKey = $this->config['sessionKey'];//"zkyj123";
        $connectTimeOut = 2;
        $readTimeOut = 10;
        $proxyhost = false;
        $proxyport = false;
        $proxyusername = false;
        $proxypassword = false;
        $this->client = new \Client($gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut);
        $this->client->setOutgoingEncoding("UTF-8");
        $statusCode = $this->client->login();
        if (! ($statusCode != null && $statusCode == "0")) {
            throw new \Exception("短信服务器连接失败".$statusCode);
        }

        foreach( $smss as $sms ){
            //print_r($sms->toArray());continue;
            $text = '【中科远景】' . $sms->content;

            if( isset( $this->config['debug'] ) && $this->config['debug'] == true ) {

                $statusCode = 0;
            }
            else {
                $statusCode = $this->client->sendSMS( explode(',',$sms->mobiles), $text );
            }

            if( $statusCode != 0 ){
                Log::info( "[短信模块]发送异常 id:{$sms->id} statusCode:".$statusCode );
                $sms->error_count ++;
                if( $sms->error_count >=3 ){
                    SmsRepository::getInstance()->updateById( $sms->id,[ 'is_send'=>1, 'error_count'=>$sms->error_count, 'status'=>3 ] );
                }
                else{
                    SmsRepository::getInstance()->updateById( $sms->id,[ 'error_count'=>$sms->error_count ] );
                }
            }
            else{
                SmsRepository::getInstance()->updateById( $sms->id,[ 'status'=>2, 'is_send'=>1 ] );
            }
        }


    }
}
